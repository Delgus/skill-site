<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\surver\models\TestCategory;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\surver\models\search\TestCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории тестов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-category-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новую категорию', ['create'], ['class' => 'btn btn-success']) ?>
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
            'description:ntext',
            [
                'attribute' => 'statusName',
                'filter' => (new TestCategory())->statusList
            ],
            'created_at:datetime',
            [
                'attribute' => 'creator',
                'content' => function ($model) {
                    return Html::a($model->creator->username, [
                        Yii::$app->controller->module->userView.$model->creator->id]);
                }
            ],
            'updated_at:datetime',
            [
                'attribute' => 'updater',
                'content' => function ($model) {
                    return Html::a($model->updater->username, [
                        Yii::$app->controller->module->userView.$model->updater->id]);
                }
            ],
        ],
    ]); ?>
</div>
