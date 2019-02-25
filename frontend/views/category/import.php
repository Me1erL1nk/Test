<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Импорт категорий';
$this->params['breadcrumbs'][] = ['label' => 'Импорт категорий', 'url' => ['import']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
