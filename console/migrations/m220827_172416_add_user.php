<?php

use yii\db\Migration;

/**
 * Class m220827170957_create_table_apple
 */
class m220827_172416_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'demo',
            'email' => 'test@test.demo',
            'auth_key' => 'MlpveSDFoqG_U0fGjd4-s3YWYzCgqfQF',
            'password_hash' => '$2y$13$9ZkVir7Egwk5YhmtFOEq8uqbGLTZwCSe89Hyf58FIzZPakf64BxGa',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
            'verification_token' => 'ljFaxL-NDoPb7KKripehZGZ5sX3pmV9p_1661502442'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'demo']);
    }

}
