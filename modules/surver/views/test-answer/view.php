<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestAnswer */

$this->title = 'Ответ #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->question->test->name,
    'url' => ['test/view', 'id' => $model->question->test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту',
    'url' => ['test-question/index', 'id' => $model->question->test->id]];
$this->params['breadcrumbs'][] = ['label' => $model->question->name, 'url' => ['test-question/view', 'id' => $model->question->id]];
$this->params['breadcrumbs'][] = ['label' => 'Ответы к вопросу', 'url' => ['index', 'id' => $model->question->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-answer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить ответ?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Назад к ответам', ['index', 'id' => $model->question->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'result',
        ],
    ]) ?>

</div>
