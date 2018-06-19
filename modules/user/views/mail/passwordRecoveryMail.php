<?php
/**
 * @var $this yii\web\View
 * @var $user app\modules\user\models\User
 */
use yii\helpers\Html;

?>
<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/auth/password-recovery-receive', 'token' => $user->confirmation_token]);
?>

Hello <?= Html::encode($user->username) ?>, follow this link to reset your password:

<?= Html::a('Reset password', $resetLink) ?>