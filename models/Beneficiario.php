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
    
    public function setAttributes($values, $safeOnly = true) {
        parent::setAttributes($values, $safeOnly);
        
        $persona = new PersonaForm();
        $persona->setAttributesAndSave($values);
        $this->personaid = $persona->id;
    }
}
