<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\surver\models\Test;
use app\modules\surver\models\TestCategory;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\surver\models\search\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тесты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать тест', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'content' => function($model){
                    return Html::a($model->name,['view','id' => $model->id]);
                }
            ],
            'description:raw',
            [
                'attribute' => 'statusName',
                'filter' => (new Test())->statusList
            ],
            [
                'attribute' => 'category',
                'value' => 'category.name',
                'filter' => (new TestCategory())->list
            ],
            'created_at:datetime',
            [
                'attribute' => 'creator',
                'content' => function($model){
                    return Html::a($model->creator->username,[
                        Yii::$app->controller->module->userView.$model->creator->id]);
                }
            ],
            [
                'attribute' => 'updated_at',
                'filter' => \yii\jui\DatePicker::widget(['language' => 'ru', 'dateFormat' => 'dd-MM-yyyy']),
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updater',
                'content' => function($model){
                    return Html::a($model->updater->username,[
                        Yii::$app->controller->module->userView.$model->updater->id]);
                }
            ],
        ],
    ]); ?>
</div>
