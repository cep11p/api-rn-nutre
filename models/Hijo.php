<?php

namespace app\models;

use Yii;
use \app\models\base\Hijo as BaseHijo;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hijo".
 */
class Hijo extends BaseHijo
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
}
