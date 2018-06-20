<?php


class LoginFormCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/login');
    }

    public function _after(FunctionalTester $I)
    {

    }

    public function emptyForm(FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->seeInTitle('Авторизация');
        $I->see('Необходимо заполнить «Логин»');
        $I->see('Необходимо заполнить «Пароль»');
    }
}
