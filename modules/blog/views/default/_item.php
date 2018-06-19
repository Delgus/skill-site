<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/** @var \app\modules\blog\models\Post $model */
?>

<div class="col-md-4" style="height:300px;border:solid black 1px;">
    <h2><?= Html::encode($model->title) ?></h2>
    <?= HtmlPurifier::process($model->description) ?>
    <p>
        <?= Html::a('Перейти к статье', ['view', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>