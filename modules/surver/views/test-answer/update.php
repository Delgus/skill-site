<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestAnswer */

$this->title = 'Редактировать ответ';
$this->params['breadcrumbs'][] = ['label' => $model->question->test->name,
    'url' => ['test/view', 'id' => $model->question->test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту',
    'url' => ['test-question/index', 'id' => $model->question->test->id]];
$this->params['breadcrumbs'][] = ['label' => $model->question->name, 'url' => ['test-question/view', 'id' => $model->question->id]];
$this->params['breadcrumbs'][] = ['label' => 'Ответы к вопросу', 'url' => ['index', 'id' => $model->question->id]];
$this->params['breadcrumbs'][] = ['label' => 'Ответ #' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="test-answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
