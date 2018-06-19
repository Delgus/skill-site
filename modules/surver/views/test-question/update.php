<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestQuestion */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['test/index']];
$this->params['breadcrumbs'][] = ['label' => $model->test->name, 'url' => ['test/view', 'id' => $model->test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту', 'url' => ['index', 'id' => $model->test->id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="test-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model')) ?>

</div>
