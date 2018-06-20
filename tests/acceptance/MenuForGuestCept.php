<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('Menu for guest is worked');

$I->amOnPage('/site/index');

$I->seeLink('Прокачайся!!!');
/** Проверка меню */
$I->seeLink('Главная');
$I->seeLink('Блог');
$I->seeLink('Тесты');
$I->seeLink('О нас');
$I->seeLink('Вход');
$I->seeLink('Регистрация');

$I->dontSeeLink('Управление');
$I->dontSeeLink('Пользователи');

$I->click('Прокачайся!!!');
$I->seeInTitle('Прокачайся!!!');

$I->click('Главная');
$I->seeInTitle('Прокачайся!!!');

$I->click('Блог');
$I->seeInTitle('Блог');

$I->click('Тесты');
$I->seeInTitle('Авторизация');

$I->click('О нас');
$I->seeInTitle('О нас');

$I->click('Вход');
$I->seeInTitle('Авторизация');

$I->click('Регистрация');
$I->seeInTitle('Регистрация');
