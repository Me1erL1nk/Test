<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adcombo_offer".
 *
 * @property int $id
 * @property int $category_id
 * @property int $is_available
 * @property string $url
 * @property string $currencyId
 * @property int $name
 * @property string $description
 * @property string $price
 */
class Offer extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%offer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currencyId', 'name','price'], 'required'],
            [['category_id'], 'default', 'value' => 0],
            [[ 'category_id', 'is_available','price'], 'integer'],
            [['currencyId'], 'string'],
            [['url'], 'url'],
            [['description', 'name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Категория',
            'is_available' => 'Доступен',
            'url' => 'Сссылка',
            'currencyId' => 'Валюта',
            'name' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
        ];
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->select(['id', 'name'])->asArray()->all(), 'id', 'name');
    }

    public function getParam()
    {
        return $this->hasMany(Param::class, ['offer_id' => 'id']);
    }

    public function getImage()
    {
        return $this->hasMany(Image::class, ['offer_id' => 'id']);
    }
}
