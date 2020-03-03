<?php

namespace app\models;

use Yii;
use \app\models\base\Beneficiario as BaseBeneficiario;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "beneficiario".
 */
class Beneficiario extends BaseBeneficiario
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
    
    /**
     * Se reciben los parametros para registrar una persona con interoperabilidad al sistema registral, con el fin de obtener una personaid
     * @param array $values
     * @param type $safeOnly
     */
    public function setAttributes($values, $safeOnly = true) {
        $persona = new PersonaForm();
        $persona->setAttributesAndSave($values);
        $this->personaid = $persona->id;
    }
}
