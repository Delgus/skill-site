<?php


use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\surver\models\TestCategory;
use app\modules\surver\models\TestAnswer;

use app\modules\surver\widgets\dynamicform\DynamicFormWidget;
$wysiwyg = Yii::$app->controller->module->wysiwyg;

?>


<div class="person-form">


    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($test, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($test, 'description')->widget($wysiwyg['class'],$wysiwyg['config']); ?>
    <?= $form->field($test, 'status')->dropDownList($test->statusList) ?>
    <?= $form->field($test, 'category_id')->dropDownList(ArrayHelper::map(TestCategory::find()->all(), 'id', 'name')) ?>



    <div class="padding-v-md">

        <div class="line line-dashed"></div>

    </div>


    <?php DynamicFormWidget::begin([

        'widgetContainer' => 'dynamicform_wrapper',

        'widgetBody' => '.container-items',

        'widgetItem' => '.question-item',

        'limit' => 10,

        'min' => 1,

        'insertButton' => '.add-question',

        'deleteButton' => '.remove-question',

        'model' => $questions[0],

        'formId' => 'dynamic-form',

        'formFields' => [
            'name',
            'description',
        ],

    ]); ?>

    <table class="table table-bordered table-striped">
         <thead>
            <tr>
                <th class="col-md-5"> Вопросы </th>
                <th>Ответы</th>
                <th class="text-center" style="width: 90px;">
                   <button type="button" class="add-question btn btn-success btn-xs">
                        <span class="glyphicon glyphicon-plus"></span>
                        </button>

                </th>

            </tr>

        </thead>

        <tbody class="container-items">

        <?php foreach ($questions as $iq => $question): ?>

            <tr class="question-item">

                <td class="vcenter">

                    <?php

                        // necessary for update action.

                        if (!$question->isNewRecord) {

                            echo Html::activeHiddenInput($question, "[{$iq}]id");
                        }

                    ?>

                <?= $form->field($question, "[$iq]name")->textInput() ?>

                <?= $form->field($question, "[$iq]description")->textarea(['rows' => '6']) ?>

                <?= $form->field($question, "[$iq]type")->dropDownList($question->types)?>

                 <?= $form->field($question, "[$iq]points");?>

                </td>

                <td>

                    <?= $this->render('_form-answers', [
                        'form' => $form,
                        'iq' => $iq,
                        'answers' => (!empty($answers[$iq])) ? $answers[$iq] : [new TestAnswer],
                    ]) ?>

                </td>

                <td class="text-center vcenter" style="width: 90px; verti">

                    <button type="button" class="remove-question btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-minus"></span>
                        </button>
                        <button type="button" class="add-question btn btn-success btn-xs">
                        <span class="glyphicon glyphicon-plus"></span>
                        </button>

                </td>

            </tr>

         <?php endforeach; ?>

        </tbody>

    </table>

    <?php DynamicFormWidget::end(); ?>

    

    <div class="form-group">

        <?= Html::submitButton('Cохранить', ['class' => 'btn btn-primary']) ?>

    </div>
    <?php ActiveForm::end(); ?>

</div>