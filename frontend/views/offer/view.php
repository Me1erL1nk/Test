<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\Image;

/* @var $this yii\web\View */
/* @var $model common\models\Offer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="offer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'is_available',
            'url:url',
            'currencyId',
            'name',
            'description',
            'price'
        ],
    ]) ?>
    <h2>Изображения</h2>

    <?= GridView::widget([
        'dataProvider' => $imageProvider,
        'summary' => false,
        'columns' => [
            'name',
            [
                'label' => 'Изображение',
                'attribute' => 'file_name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(Image::UPLOAD_PATH . $model->file_name, ['style' => 'width:100px;']);
                },

            ],
        ],
    ]) ?>

    <h2>Параметры</h2>

    <?= GridView::widget([
        'dataProvider' => $paramProvider,
        'summary' => false,
        'columns' => [
            'name',
            'value'
        ],
    ]) ?>
</div>
