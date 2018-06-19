<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\surver\models\TestQuestion;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\surver\models\search\TestQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var \app\modules\surver\models\Test $test */

$this->title = 'Вопросы к тесту';
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['test/index']];
$this->params['breadcrumbs'][] = ['label' => $test->name, 'url' => ['test/view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать вопрос', ['create', 'id' => $test->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'content' => function ($model) {
                    return Html::a($model->name, ['view', 'id' => $model->id]);
                }
            ],
            'description:html',
            'points',
            [
                'attribute' => 'typeName',
                'filter' => (new TestQuestion())->types
            ],
            'created_at:datetime',
            [
                'attribute' => 'creator',
                'content' => function ($model) {
                    return Html::a($model->creator->username, [
                        Yii::$app->controller->module->userView, 'id' => $model->creator->id]);
                }
            ],
            'updated_at:datetime',
            [
                'attribute' => 'updater',
                'content' => function ($model) {
                    return Html::a($model->updater->username, [
                        Yii::$app->controller->module->userView, 'id' => $model->updater->id]);
                }
            ],
        ],
    ]); ?>
</div>
