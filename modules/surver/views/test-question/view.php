<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestQuestion */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['test/index']];
$this->params['breadcrumbs'][] = ['label' => $model->test->name, 'url' => ['test/view', 'id' => $model->test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту', 'url' => ['index', 'id' => $model->test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этот вопрос?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Ответы к вопросу', ['test-answer/index', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:raw',
            'points',
            'typeName',
            'created_at:datetime',
            [
                'attribute' => 'creator',
                'value' => $model->creator->username,
            ],
            'updated_at:datetime',
            [
                'attribute' => 'updater',
                'value' => $model->updater->username,
            ],
            'test.name',
        ],
    ]) ?>

</div>
