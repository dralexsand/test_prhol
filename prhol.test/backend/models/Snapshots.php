<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "snapshots".
 *
 * @property int $id
 * @property int $generation_id
 * @property string|null $data
 * @property int $created_at
 * @property int $updated_at
 */
class Snapshots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'snapshots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['generation_id', 'created_at', 'updated_at'], 'required'],
            [['generation_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'generation_id' => 'Generation ID',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getListGenerationIds()
    {
        $sql = "SELECT generation_id  FROM snapshots";
        $ids = Yii::$app->db->createCommand($sql)->queryAll();
        return array_values($ids);
    }

    public static function generateGenerationId()
    {
        //if ($length < 11) $length = 11;
        $length = 11;
        $min = "1" . str_pad('', $length, "0", STR_PAD_RIGHT);
        $max = "9" . str_pad('', $length, "9", STR_PAD_RIGHT);
        $random_int = random_int(intval($min), intval($max));
        return $random_int;
    }

    public static function getRandomGeneratationId()
    {
        $list = self::getListGenerationIds();
        $generationId = self::generateGenerationId();

        if (!empty($list)) {
            while (in_array($generationId, $list)) {
                $generationId = self::generateGenerationId();
            }
        }
        return $generationId;
    }

}
