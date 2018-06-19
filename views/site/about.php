<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-2">
        <img class="img-circle" height="150" src="/uploads/yaaa.jpg"/>
    </div>
    <div class="col-md-10">
        <p>
            Меня зовут Алексей Долгов. Мне - 28 лет. Я начинающий web-разработчик и это мой первый более-менее серьезный
            проект. До этого я работал совершенно в других областях, но вдруг в апреле 2017 решил круто изменить свою
            жизнь.
            И теперь уверенно могу сказать что нет ничего невозможного)
        </p>
        <p>
            Я на  <?=Html::a('Github','https://github.com/Delgus')?>
        </p>
        <p>
            Я в  <?=Html::a('Vk','https://vk.com/alex_delgus')?>
        </p>
    </div>
</div>
