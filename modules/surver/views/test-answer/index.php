<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var \app\modules\surver\models\TestQuestion $test_question */

$this->title = 'Ответы к вопросу ';
$this->params['breadcrumbs'][] = ['label' => $test_question->test->name,
    'url' => ['test/view', 'id' => $test_question->test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту', 'url' => ['test-question/index', 'id' => $test_question->test->id]];
$this->params['breadcrumbs'][] = ['label' => $test_question->name, 'url' => ['test-question/view', 'id' => $test_question->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-answer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить вариант ответа', ['create', 'id' => $test_question->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'result',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
