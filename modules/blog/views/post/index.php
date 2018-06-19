<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\blog\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Новая статья', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title:ntext',
            'description:ntext',
            'text:ntext',
            [
                'attribute' => 'statusName',
                'filter' => (new Post())->statusList
            ],
            'created_at:datetime',
            [
                'attribute' => 'creator',
                'content' => function ($model) {
                    return Html::a($model->creator->username, []);
                }
            ],
            'updated_at:datetime',
            [
                'attribute' => 'updater',
                'content' => function ($model) {
                    return Html::a($model->updater->username, []);
                }
            ],
            [
                'attribute' => 'category',
                'value' => 'category.name',
                'filter' => (new \app\modules\blog\models\PostCategory())->list
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
