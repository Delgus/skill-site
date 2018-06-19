<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\blog\models\Post $model */
/** @var \app\modules\blog\models\Comment $comment */

$this->title = $model->title;
?>
<div class="surver-default-index">
    <h2><?= $model->title ?></h2>
    <p><?= $model->text ?></p>
    <p>
        <?= Html::a('Назад', Yii::$app->request->headers['referer'], ['class' => 'btn btn-warning']) ?>
    </p>

    <p>
    <h3> Комментарии </h3></p>

    <div class="comment-form">
        <?php if (Yii::$app->user->isGuest): ?>
            Чтобы прокомментировать статью -
            <?= Html::a('зарегистрируйтесь', ['/user/auth/registration']) ?>
            или
            <?= Html::a('войдите', ['/user/auth/login']) ?>

        <?php else: ?>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($comment, 'text')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Оставить комментарий', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        <?php endif; ?>

    </div>
    </p>
    <p> <?= \app\modules\blog\widgets\comments\Comments::widget(['post_id' => $model->id]) ?></p>
</div>