<?php
/**
 * @var $this yii\web\View
 * @var $model app\modules\user\models\forms\LoginForm
 */

use app\modules\user\components\GhostHtml;
use app\modules\user\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Авторизация';
?>

    <div class="container" id="login-wrapper">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= UserManagementModule::t('front', 'Authorization') ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['autocomplete' => 'off'],
                            'validateOnBlur' => false,
                            'fieldConfig' => [
                                'template' => "{input}\n{error}",
                            ],
                        ]) ?>

                        <?= $form->field($model, 'username')
                            ->textInput(['placeholder' => $model->getAttributeLabel('username'), 'autocomplete' => 'off']) ?>

                        <?= $form->field($model, 'password')
                            ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'autocomplete' => 'off']) ?>

                        <?= (isset(Yii::$app->user->enableAutoLogin) && Yii::$app->user->enableAutoLogin) ? $form->field($model, 'rememberMe')->checkbox(['value' => true]) : '' ?>

                        <?= Html::submitButton('Войти',
                            ['class' => 'btn btn-lg btn-primary btn-block']
                        ) ?>

                        <div class="row registration-block">

                            <div class="col-md-offset-4 col-md-6 text-right">
                                <?= Html::a(
                                    UserManagementModule::t('front', "Forgot password ?"),
                                    ['/user/auth/password-recovery']
                                ) ?>
                            </div>
                        </div>
                        <?= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['/user/auth/auth'],
                            'popupMode' => false,
                        ]) ?>

                        <?php ActiveForm::end() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$css = <<<CSS
html, body {
	background: #eee;
	-webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);
	box-shadow: inset 0 0 100px rgba(0,0,0,.5);
	height: 100%;
	min-height: 100%;
	position: relative;
}
#login-wrapper {
	position: relative;
	top: 30%;
}
#login-wrapper .registration-block {
	margin-top: 15px;
}
CSS;

$this->registerCss($css);
?>