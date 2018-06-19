<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $items = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Блог', 'url' => ['/blog/default/index']],
        ['label' => 'Тесты', 'url' => ['/surver/default/index']],
        ['label' => 'О нас', 'url' => ['/site/about']],
    ];
    if (Yii::$app->user->isGuest) {
        $items [] = ['label' => 'Вход', 'url' => ['/user/auth/login']];
        $items [] = ['label' => 'Регистрация', 'url' => ['/user/auth/registration']];
    } else {
        $items [] =
            '<li>'
            . Html::beginForm(['/user/auth/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    if (Yii::$app->user->isSuperadmin) {
        $items [] = ['label' => 'Управление', 'items' => [
            ['label' => 'Тесты', 'url' => ['/surver/test/index']],
            ['label' => 'Категории тестов', 'url' => ['/surver/test-category/index']],
            ['label' => 'Статьи', 'url' => ['/blog/post/index']],
            ['label' => 'Категории статей', 'url' => ['/blog/post-category/index']],
            ['label' => 'Коментарии', 'url' => ['/blog/comment/index']],
        ]];
        $items [] = ['label' => 'Пользователи','items' => \app\modules\user\UserManagementModule::menuItems()];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; DELGUS COMPANY <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
