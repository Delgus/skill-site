<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\TestCategory */

$this->title = 'Создание новой категории';
$this->params['breadcrumbs'][] = ['label' => 'Категории тестов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model')) ?>

</div>
