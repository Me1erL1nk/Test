<?php

namespace frontend\models;

use common\models\Category;
use common\models\Image;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use SimpleXMLElement;

class CategoryXMLForm extends Model
{

    public $file;

    private $model;
    private $models;
    private $xml;


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

            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Файл',


        ];
    }

    public function load($data, $formName = null)
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        $this->xml = new SimpleXMLElement(file_get_contents($this->file->tempName));
        $this->loadAttributes();

        return true;
    }


    public function validate($attributeNames = null, $clearErrors = true)
    {
        $isValid = parent::validate($attributeNames, $clearErrors);

        foreach ($this->models as $model) {
            if(!$model->validate()) {
                $isValid = false;
                $this->addErrors($model->errors);
            }
        }

        return $isValid;
    }

    public function save()
    {
        foreach ($this->models as $model) {
            $model->save(false);
        }

    }

    private function loadAttributes()
    {
        foreach ($this->xml->children() as $category) {

            $model = new Category();
            $model->id = (string)$category->attributes()->id;
            $model->parent_id =(string)$category->attributes()->parentId;
            $model->title = (string)$category;

            $this->models[] = $model;
        }
    }
}