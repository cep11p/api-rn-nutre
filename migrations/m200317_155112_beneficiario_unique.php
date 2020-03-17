<?php

use yii\db\Migration;

/**
 * Class m200317_155112_beneficiario_unique
 */
class m200317_155112_beneficiario_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('beneficiario', 'personaid', $this->integer()->notNull()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200317_155112_beneficiario_unique cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200317_155112_beneficiario_unique cannot be reverted.\n";

        return false;
    }
    */
}
