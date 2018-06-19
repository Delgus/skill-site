<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории тестов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-category-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
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
        ],
    ]) ?>

</div>
