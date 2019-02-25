<?php

namespace frontend\models;

use common\models\Image;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class ImageForm extends Model
{

    public $imageFile;
    public $offer_id = null;
    public $name = null;
    public $file_name;
    private $model;


    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    public function rules()
    {
        return [
            [['offer_id', 'name'], 'required'],
            [['offer_id', 'name', 'file_name'], 'string', 'max' => 45],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_id' => 'Товар',
            'name' => 'Название',
            'imageFile' => 'Изображение'

        ];
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->file_name = $this->imageFile->baseName . '.' . $this->imageFile->extension;

        return parent::validate($attributeNames, $clearErrors);
    }

    public function save()
    {
        $this->model = new Image();
        $this->model->setAttributes($this->attributes, false);
        $this->imageFile->saveAs(Yii::getAlias('@frontend/web' . Image::UPLOAD_PATH) . $this->imageFile->baseName . '.' . $this->imageFile->extension);
        $this->model->save(false);
    }
}