<?php

use yii\db\Migration;

/**
 * Class m200424_150427_create_snapshots
 */
class m200424_150427_create_snapshots extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%snapshots}}', [
            'id' => $this->primaryKey(),
            'generation_id' => $this->integer()->notNull(),
            'data' => $this->json(),
            //'delete' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%snapshots}}');
        return false;
    }

}
