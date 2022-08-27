<?php

use yii\db\Migration;

/**
 * Class m220827170957_create_table_apple
 */
class m220827_170957_create_table_apple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%apple}}', [
            'id' => $this->char(36)->notNull(),
            'color' => $this->string(10)->notNull(),
            'appearance_date' => $this->integer(10)->notNull(),
            'fall_date' => $this->integer(10),
            'size' => $this->integer(3)->notNull(),
            'status' => $this->smallInteger(1)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-apple', '{{%apple}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }

}
