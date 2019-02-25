<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="site-index">
    <div>    <?= Html::a('Запуск импорта', Url::toRoute('site/import')); ?></div>
    <div>    <?= Html::a('Импорт категорий', Url::toRoute('category/import')); ?></div>
    <div><?= Html::a('Импорт товара', Url::toRoute('offer/import')); ?></div>
</div>
