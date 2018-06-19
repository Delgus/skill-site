<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/** @var \app\modules\surver\models\Test $model */
?>

<div class="col-md-6" style="height:300px;border:solid black 1px;">
    <h2><?= Html::encode($model->name) ?></h2>
    <?= HtmlPurifier::process($model->description) ?>
    <p>
        <?= Html::a('Пройти тест', ['preview', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>