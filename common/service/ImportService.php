<?php

namespace common\service;

use common\models\Image;
use Yii;
use common\models\Category;
use SimpleXMLElement;
use common\models\Offer;
use common\models\Param;

class ImportService
{
    const EXAMPLE_PATH = '/uploads/example/';


    /**
     * @param $files
     * @throws \Exception
     */
    public function import($files)
    {

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $this->importCategory($files['category']);
            $this->importOffer($files['offer']);

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            //throw $e;
            return false;
        }

        return true;

    }

    private function importCategory($fileName)
    {

        $file = file_get_contents((Yii::getAlias('@frontend/web' . self::EXAMPLE_PATH . $fileName)));

        $xml = new SimpleXMLElement($file);

        foreach ($xml->children() as $category) {

            $model = new Category();
            $model->id = (string)$category->attributes()->id;
            $model->parent_id = (string)$category->attributes()->parentId;
            $model->title = (string)$category;

            $model->save();
        }
    }

    /**
     * @param $fileName
     * @throws \Exception
     */
    private function importOffer($fileName)
    {
        $file = file_get_contents((Yii::getAlias('@frontend/web' . self::EXAMPLE_PATH . $fileName)));

        $xml = new SimpleXMLElement($file);

        $model = new Offer();

        $model->id = (string)$xml->attributes()->id;
        $model->is_available = (int)(string)$xml->attributes()->available;
        $model->url = (string)$xml->url;
        $model->price = (string)$xml->price;
        $model->currencyId = (string)$xml->currencyId;
        $model->category_id = (string)$xml->categoryId;
        $model->name = (string)$xml->name;
        $model->description = (string)$xml->description;

        $params = $this->prepareParam($model, $xml);


        $model->save(false);

        Yii::$app->db->createCommand()->batchInsert(Param::tableName(), ['offer_id', 'name', 'value'], $params)->execute();

        $this->importImage($model, $xml);


    }

    private function prepareParam($model, $xml)
    {
        $params = [];

        foreach ($xml->param as $p) {

            $params[] = [
                'offer_id' => $model->id,
                'name' => (string)$p->attributes()->name,
                'value' => (string)$p,
            ];
        }

        return $params;
    }

    private function importImage($model, $xml)
    {
        foreach ($xml->pictures->picture as $picture) {

            $file = file_get_contents((Yii::getAlias('@frontend/web' . self::EXAMPLE_PATH . (string)$picture)));
            $info = pathinfo((Yii::getAlias('@frontend/web' . self::EXAMPLE_PATH . (string)$picture)));

            file_put_contents((Yii::getAlias('@frontend/web' . Image::UPLOAD_PATH . (string)$picture)), $file);

            $image = new Image();
            $image->offer_id = $model->id;
            $image->name = $info['filename'];
            $image->file_name = $info['basename'];
            $image->save(false);
        }


    }

}