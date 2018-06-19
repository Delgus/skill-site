<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\Test */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Вопросы теста', ['test-question/index', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Назад к тестам', ['index', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:raw',
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
            'statusName',
            'category.name',
        ],
    ]) ?>

</div>
