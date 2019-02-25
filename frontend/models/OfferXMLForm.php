<?php

namespace frontend\models;

use common\models\Offer;
use common\models\Param;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use SimpleXMLElement;
use yii\web\XmlResponseFormatter;

class OfferXMLForm extends Model
{

    public $file;

    private $model;
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


    /**
     * @throws \Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $params = $this->prepareParams();
        $this->model->save(false);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->model->save(false);

            Yii::$app->db->createCommand()->batchInsert(Param::tableName(), ['offer_id', 'name', 'value'], $params)->execute();

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (!$this->model->validate()) {
            $this->addErrors($this->model->errors);
            return false;
        }

        return parent::validate($attributeNames, $clearErrors);
    }


    /**
     * @param $model
     * @param $xml
     */
    private function loadAttributes()
    {
        $this->model->id = (string)$this->xml->attributes()->id;
        $this->model->is_available = (int)(string)$this->xml->attributes()->available;
        $this->model->url = (string)$this->xml->url;
        $this->model->price = (string)$this->xml->price;
        $this->model->currencyId = (string)$this->xml->currencyId;
        $this->model->category_id = (string)$this->xml->categoryId;
        $this->model->name = (string)$this->xml->name;
        $this->model->description = (string)$this->xml->description;
    }

    private function prepareParams()
    {
        $params = [];

        foreach ($this->xml->param as $p) {

            $params[] = [
                'offer_id' => $this->model->id,
                'name' => (string)$p->attributes()->name,
                'value' => (string)$p,
            ];
        }

        return $params;
    }
}