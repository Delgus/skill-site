<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\surver\models\Test */

$this->title = 'Создать тест';
$this->params['breadcrumbs'][] = ['label' => 'Тесты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('test','questions','answers')) ?>

</div>
