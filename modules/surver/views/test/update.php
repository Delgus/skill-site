<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\Test */

$this->title = 'Редактировать тест: ' . $test->name;
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $test->name, 'url' => ['view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('test','questions','answers')) ?>

</div>
