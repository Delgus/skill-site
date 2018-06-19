<?php

use yii\bootstrap\Html;

/** @var \app\modules\surver\models\TestResult $model */
/** @var \app\modules\surver\models\Test $test */
/** @var \app\modules\surver\models\TestQuestion $question */
/** @var \app\modules\surver\models\TestAnswer $answer */
$text = json_decode($model->answers);
$this->title = 'Тест - '.$text->test_name.' пройден!';
?>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Ваш результат</h3>
        </div>
        <div class="panel-body">
            <p>
            Пройден тест: <?=$text->test_name?>.
            Правильных ответов: <?= $model->test_result ?> .
                </p>
            <?php foreach ($text->questions as $question):?>

        <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$question->name?></h3>
        </div>
        <div class="panel-body">
                <?php foreach ($question->answers as $id => $answer):?>
                <?php ($answer->mark)?$class = 'bg-warning':$class = '';?>
                <?php ($answer->result)?$class .= ' text-success':$class .= ' text-danger';?>
                <?=Html::tag('p', $answer->text,['class' => $class]);?>
            <?php endforeach;?>
        </div>
    </div>
<?php endforeach;?>
    </div>
</div>
<?= Html::a('Перейти на главную', ['index'], ['class' => 'btn btn-primary']) ?>