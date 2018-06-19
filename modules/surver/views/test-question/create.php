<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestQuestion */
/** @var \app\modules\surver\models\Test $test */

$this->title = 'Создать вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['test/index']];
$this->params['breadcrumbs'][] = ['label' => $test->name, 'url' => ['test/view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы к тесту', 'url' => ['index', 'id' => $test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model')) ?>

</div>
