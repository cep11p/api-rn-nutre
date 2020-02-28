<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "beneficiario".
 *
 * @property integer $id
 * @property integer $personaid
 * @property string $estado
 * @property string $aliasModel
 */
abstract class Beneficiario extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beneficiario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personaid'], 'required'],
            [['personaid'], 'integer'],
            [['estado'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'personaid' => 'Personaid',
            'estado' => 'Estado',
        ];
    }




}