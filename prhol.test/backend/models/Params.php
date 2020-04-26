<?php

namespace app\models;

/**
 * This is the model class for table "params".
 *
 * @property int $id
 * @property string $name
 * @property int $count_apples
 * @property int $time_to_disappearance
 * @property int $unit
 * @property int|null $offset_distanse_between_items
 * @property int $length_generation_id
 * @property int $time_offset_new_generation_element
 * @property int $created_at
 * @property int $updated_at
 */
class Params extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['count_apples', 'time_to_disappearance', 'unit', 'offset_distanse_between_items', 'length_generation_id', 'time_offset_new_generation_element', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count_apples' => 'Количество яблок',
            'time_to_disappearance' => 'Критическое время на земле',
            'unit' => 'Коэффициент(масштаб времени)',
            'offset_distanse_between_items' => 'Расстояние между яблоками',
            'length_generation_id' => 'Длина ключа generation_id',
            'time_offset_new_generation_element' => 'Сдвиг по времени при генерации экземпляров',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
