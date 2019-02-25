<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Offer;
use common\models\Image;

/* @var $this yii\web\View */
/* @var $model common\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'offer_id')->dropDownList(Offer::getList()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    if($this->context->action->id == 'create') {
         echo $form->field($model, 'imageFile')->fileInput();
    } else {
       echo  Html::img(Image::UPLOAD_PATH . $model->file_name);
    }
    ?>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
