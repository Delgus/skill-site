<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestAnswer */
/** @var \app\modules\surver\models\TestQuestion $test_question */

$this->title = 'Добавление ответа';
$this->params['breadcrumbs'][] = ['label' => $test_question->test->name,
    'url' => ['test/view', 'id' => $test_question->test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту', 'url' => ['test-question/index', 'id' => $test_question->test->id]];
$this->params['breadcrumbs'][] = ['label' => $test_question->name, 'url' => ['test-question/view', 'id' => $test_question->id]];
$this->params['breadcrumbs'][] = ['label' => 'Ответы к вопросу', 'url' => ['index', 'id' => $test_question->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model')) ?>

</div>
