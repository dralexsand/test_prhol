<?php

use yii\db\Migration;

/**
 * Class m200426_164634_create_params
 */
class m200426_164634_create_params extends Migration
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

        // $count_apples, $time_to_disappearance, $unit, $offset_distanse_between_items, $length_generation_id, $time_offset_new_generation_element

        $this->createTable('{{%params}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),

            'count_apples' => $this->integer()->notNull()->defaultValue(53),
            'time_to_disappearance' => $this->integer()->notNull()->defaultValue(5),
            'unit' => $this->integer()->notNull()->defaultValue(30),
            'offset_distanse_between_items' => $this->integer()->defaultValue(10),
            'length_generation_id' => $this->integer()->notNull()->defaultValue(10),
            'time_offset_new_generation_element' => $this->integer()->notNull()->defaultValue(3600),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%params}}');
        return false;
    }
}
