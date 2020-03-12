<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Beneficiario;

/**
* BeneficiarioSearch represents the model behind the search form about `app\models\Beneficiario`.
*/
class BeneficiarioSearch extends Beneficiario
{
    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['id', 'personaid', 'cantidad_hijo'], 'integer'],
            [['estado', 'edad_por_hijo'], 'safe'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
    * Creates data provider instance with search query applied
    *
    * @param array $params
    *
    * @return ActiveDataProvider
    */
    public function search($params)
    {
        $query = Beneficiario::find();
        $pagesize = (!isset($params['pagesize']) || !is_numeric($params['pagesize']) || $params['pagesize']==0)?20:intval($params['pagesize']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pagesize,
                    'page' => (isset($params['page']) && is_numeric($params['page']))?$params['page']:0
                ],
        ]);

        $this->load($params, '');

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        /********** Se Obtiene una coleccion de Personas **********/
        $personaForm = new PersonaForm();
        $coleccion_persona = array();
        $lista_personaid = array();
        if(isset($params['global_param']) && !empty($params['global_param'])){
            $persona_params["global_param"] = $params['global_param'];
        }
        
        if(isset($params['localidadid']) && !empty($params['localidadid'])){
            $persona_params['localidadid'] = $params['localidadid'];
        }
        
        if(isset($params['calle']) && !empty($params['calle'])){
            $persona_params['calle'] = $params['calle'];    
        }
        
        
        if (isset($persona_params)) {
            $coleccion_persona = $personaForm->buscarPersonaEnRegistral($persona_params);
            $lista_personaid = $this->obtenerListaIds($coleccion_persona);

            if (count($lista_personaid) < 1) {
                $query->where('0=1');
            }
        }
        /********** Fin de coleccion de Personas **************/
        
        /*********** Se filtran los Beneficiarios **************/
        #Se prepara el filtro por coleccion ids de beneficiarios
        if(isset($params['ids'])){
            #Se realiza un filtrado de multiples ids
            $lista_id = explode(",", $params['ids']);
            $query->andWhere(array('in', 'id', $lista_id));
        
        #Sino se realiza filtrado por ids realizamos un filtrado normal de multiples criterios
        }else{
            #Criterios numericos
            $query->andFilterWhere([
                'id' => $this->id,
                'personaid' => $this->personaid,
                'cantidad_hijo' => $this->cantidad_hijo,
            ]);
            
            #Criterios por strings
            $query->andFilterWhere(['like', 'estado', $this->estado])
                ->andFilterWhere(['like', 'edad_por_hijo', $this->edad_por_hijo]);
            
            #Criterio de lista de personas.... lista de personaid
            if(count($lista_personaid)>0){
                $query->andWhere(array('in', 'personaid', $lista_personaid));
            }
        }
        
        /******************** Fin de filtrado de Beneficiarios **************/
        
        /******* Se obtiene la coleccion de Beneficiario filtrados ******/
        $coleccion_beneficiario = array();
        foreach ($dataProvider->getModels() as $value) {
            $coleccion_beneficiario[] = $value->toArray();
        }
        
        /************ Se vincunlan las personas correspondiente a cada Desinatario ****************/
        if(count($coleccion_persona)>0){
            $coleccion_beneficiario = $this->vincularPersona($coleccion_beneficiario, $coleccion_persona);
        }else{
            $coleccion_persona = $this->obtenerPersonaVinculada($coleccion_beneficiario);
            $coleccion_beneficiario = $this->vincularPersona($coleccion_beneficiario, $coleccion_persona);
        } 
        
        $paginas = ceil($dataProvider->totalCount/$pagesize);           
        $data['pagesize']=$pagesize;            
        $data['pages']=$paginas;    
        $data['total_filtrado']=$dataProvider->totalCount;
        $data['success']=(count($coleccion_beneficiario)>0)?true:false;
        $data['resultado']=$coleccion_beneficiario;
        
        return $data;
    }
    
    /**
     * Se obtienen las personas que están vinculados a la lista de beneficiarios
     * @param array $coleccion_beneficiario
     * @return array
     */
    private function obtenerPersonaVinculada($coleccion_beneficiario = array()) {
        $personaForm = new PersonaForm();
        $ids='';
        foreach ($coleccion_beneficiario as $model) {
            $ids .= (empty($ids))?$model['personaid']:','.$model['personaid'];
        }
        
        $coleccion_persona = $personaForm->buscarPersonaEnRegistral(array("ids"=>$ids));        
        
        return $coleccion_persona;
    }
    
    /**
     * Se vinculan las personas a la lista de beneficiarios
     * @param array $coleccion_beneficiario
     * @param array $coleccion_persona
     * @return array
     */
    private function vincularPersona($coleccion_beneficiario = array(), $coleccion_persona = array()) {
        $i=0;
        foreach ($coleccion_beneficiario as $model) {
            foreach ($coleccion_persona as $persona) {
                if(isset($model['personaid']) && isset($persona['id']) && $model['personaid']==$persona['id']){                    
                    $model['persona'] = $persona;
                    $model['persona']['ultimo_estudio'] = $this->getUltimoEstudio($persona['estudios']);
                    $coleccion_beneficiario[$i] = $model;
                }
            }
            $i++;
        }
        
        return $coleccion_beneficiario;
    }
    
    /**
     * Devolvemos el ultimo estudio realizado
     * @param array $estudios
     */
    private function getUltimoEstudio($estudios){
        $primera_vez = true;
        $ultimo = "";
        foreach ($estudios as $value) {
            if($primera_vez){
                $ultimo = $value;
                $primera_vez = false;
            }
            $ultimo = (intval($ultimo['anio'])>intval($value['anio']))?$ultimo:$value;
        }
        
        return $ultimo;
    }
    
    /**
     * De una coleccion de persona, se obtienen una lista de ids
     * @param array $coleccion lista de personas
     * @return array
     */
    private function obtenerListaIds($coleccion = array()) {
        
        $lista_ids = array();
        foreach ($coleccion as $col) {
            $lista_ids[] = $col['id'];
        }
        
        return $lista_ids;    
    }
}