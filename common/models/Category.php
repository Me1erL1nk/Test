<?php

namespace common\models;

use common\models\base\BaseModel;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adcombo_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 */
class Category extends BaseModel
{
    /**
     * {@inheritdoc}
     */

    public static function tableName(): string
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['parent_id'], 'default', 'value' => 0],
            [['title'], 'string', 'max' => 45],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родительская категория',
            'title' => 'Название',
        ];
    }


    public static function getList()
    {
        return ArrayHelper::map(self::find()->select(['id', 'title'])->asArray()->all(), 'id', 'title');
    }
}
