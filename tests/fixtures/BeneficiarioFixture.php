<?php

namespace app\tests\fixtures;
use yii\test\ActiveFixture;

class BeneficiarioFixture extends ActiveFixture{
    
    public $modelClass = '\app\models\Beneficiario';
    
    public function init() {
        $this ->dataFile = \Yii::getAlias('@app').'/tests/_data/beneficiario.php';
        parent::init();
    }
    
    public function unload()
    {
        parent::unload();
        $this->resetTable();
    }
    
}

