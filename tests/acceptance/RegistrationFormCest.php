<?php


class RegistrationFormCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/user/auth/registration');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function emptyForm(AcceptanceTester $I)
    {
        $I->submitForm('#registration-form', []);
        $I->seeInTitle('Регистрация');
        $I->see('Необходимо заполнить «Логин»');
        $I->see('Необходимо заполнить «Пароль»');
        $I->see("Необходимо заполнить «Повторите пароль");
        $I->see("Неправильный проверочный код.");
    }
}
