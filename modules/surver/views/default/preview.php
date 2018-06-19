<?php

use yii\helpers\Html;

/** @var \app\modules\surver\models\Test $model */

$this->title = 'Тест - '.$model->name;
?>
<div class="surver-default-index">
    <h2><?= $model->name ?></h2>
    <p><?= $model->description ?></p>
    <p>
        <?= Html::a('Назад', Yii::$app->request->headers['referer'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Поехали', ['go', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <h3> Лучшие результаты </h3>
    <?= app\modules\surver\widgets\top\TopWidget::widget(['test_id' => $model->id]) ?>
</div>