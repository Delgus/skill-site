<?php

use yii\bootstrap\Html;
use app\modules\surver\models\TestQuestion;

/** @var \app\modules\surver\models\TestResult $model */
/** @var \app\modules\surver\models\TestQuestion $one */


$this->title = 'Тест - ' . $model->test_name;
?>


<?= Html::beginForm() ?>
<?php foreach ($model->questions as $key => $one): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= $one['question'] ?></h3>
        </div>
        <div class="panel-body">
            <?php if ($one['type'] == TestQuestion::TYPE_RADIOLIST): ?>
                <?= Html::radioList('TestResult[answers][' . $key . ']', isset($model->answers[$key]) ? $model->answers[$key] : null, $one['answers']); ?>
            <?php else: ?>
                <?= Html::checkboxList('TestResult[answers][' . $key . ']', isset($model->answers[$key]) ? $model->answers[$key] : null, $one['answers']); ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
<?= Html::submitButton('Ответить', ['class' => 'btn btn-success']); ?>
<?= Html::endForm(); ?>