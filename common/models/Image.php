<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "adcombo_image".
 *
 * @property int $id
 * @property string $offer_id
 * @property string $name
 */
class Image extends BaseModel
{
    const UPLOAD_PATH = '/uploads/';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offer_id', 'name'], 'required'],
            [['offer_id', 'name', 'file_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_id' => 'Товар',
            'name' => 'Название',
            'file_name' => 'Изображение'
        ];
    }
}
