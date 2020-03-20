<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;
use yii\base\Exception;
/**Models**/
use app\models\Beneficiario;

class BeneficiarioController extends ActiveController{
    
    public $modelClass = 'app\models\Beneficiario';
    
    public function behaviors()
    {

        $behaviors = parent::behaviors();     

        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];

        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        $behaviors['authenticator'] = $auth;

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::className(),
        ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'create'
        ];      

        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['*'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['?'],
                ]
            ]
        ];



        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    
    }
    
    public function prepareDataProvider() 
    {
        try {
            $searchModel = new \app\models\BeneficiarioSearch();
            $resultado = $searchModel->search(\Yii::$app->request->queryParams);
            
            return $resultado;

        }catch (Exception $exc) {
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(400, $mensaje);
        }
    }
    
    /**
     * Se crea un Beneficiario y se vincula con una Persona()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {        
        $resultado['message']='Se registra un Beneficiario';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $model = new Beneficiario();
            $model->setAttributesAndValidatePersona($param);
            //Registrar y validar personaid
            
            if(!$model->save()){
                //realizamos un borrado logico de la persona registrado y mostramos el error
                $resultado = \Yii::$app->registral->borrarPersona($model->personaid);
                $arrayErrors=$model->getErrors();
                throw new Exception(json_encode($arrayErrors));
            }
            
            $transaction->commit();
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return  $resultado;
           
        }catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $transaction->rollBack();
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(400, $mensaje);
        }

    }
    
    /**
     * Se modificar un Beneficiario y se vincula con una Persona()
     * @return array Un array con datos
     * @throws \yii\web\HttpException
     */
    public function actionUpdate($id)
    {
        $resultado['message']='Se modifica un Beneficiario';
        $param = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $model = Beneficiario::findOne(['id'=>$id]);            
            if($model==NULL){
                $msj = 'El beneficiario con el id '.$id.' no existe!';
                throw new Exception($msj);
            }
            
            $model->setAttributesAndValidatePersona($param);
            //Registrar y validar personaid
            
            if(!$model->save()){
                //realizamos un borrado logico de la persona registrado y mostramos el error
                $resultado = \Yii::$app->registral->borrarPersona($model->personaid);
                $arrayErrors=$model->getErrors();
                throw new Exception(json_encode($arrayErrors));
            }
            
            $transaction->commit();
            
            $resultado['success']=true;
            $resultado['data']['id']=$model->id;
            
            return  $resultado;
           
        }catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $transaction->rollBack();
            $mensaje =$exc->getMessage();
            throw new \yii\web\HttpException(500, $mensaje);
        }

    }
    
}