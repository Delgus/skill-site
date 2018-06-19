<?php
use yii\helpers\Html;
use app\modules\surver\widgets\dynamicform\DynamicFormWidget;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-answers',

    'widgetItem' => '.answer-item',

    'limit' => 4,

    'min' => 1,

    'insertButton' => '.add-answer',

    'deleteButton' => '.remove-answer',

    'model' => $answers[0],

    'formId' => 'dynamic-form',

    'formFields' => [

        'name',
        'result'

    ],

]); ?>

<table class="table table-bordered">

    <thead>

        <tr>

            <th>Содержание</th>
            <th style="width: 90px;">Результат</th>

            <th class="text-center">

                <button type="button" class="add-answer btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>

            </th>

        </tr>

    </thead>

    <tbody class="container-answers">

    <?php foreach ($answers as $ia => $answer): ?>

        <tr class="answer-item">

            <td class="vcenter">

                <?php

                    // necessary for update action.

                    if (! $answer->isNewRecord) {

                        echo Html::activeHiddenInput($answer, "[{$iq}][{$ia}]id");

                    }

                ?>

                <?= $form->field($answer, "[{$iq}][{$ia}]name")->label(false)->textInput() ?>
                
            </td>
            <td class="vcenter" style="width: 130px;">
                <?= $form->field($answer, "[{$iq}][{$ia}]result")->label(false)->dropdownList(['Неверный','Верный']) ?>
            </td>

            <td class="text-center vcenter" style="width: 90px;">

                <button type="button" class="remove-answer btn btn-danger btn-xs">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>

            </td>

        </tr>

     <?php endforeach; ?>

    </tbody>

</table>

<?php DynamicFormWidget::end(); ?>