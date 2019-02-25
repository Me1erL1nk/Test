<?php

namespace common\models;
use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "adcombo_param".
 *
 * @property int $id
 * @property int $offer_id
 * @property string $name
 * @property string $value
 */
class Param extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%param}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offer_id', 'name', 'value'], 'required'],
            [['offer_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'offer_id' => 'Товар',
            'name' => 'Параметр',
            'value' => 'Значение',
        ];
    }
}
