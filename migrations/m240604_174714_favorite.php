<?php

use yii\db\Migration;

/**
 * Class m240604_174714_favorite
 */
class m240604_174714_favorite extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favorite', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'product_id' => $this->integer(),
        ]);
        $this->createIndex('{{%idx-favorite-user_id}}', '{{%favorite}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240604_174714_favorite cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240604_174714_favorite cannot be reverted.\n";

        return false;
    }
    */
}
