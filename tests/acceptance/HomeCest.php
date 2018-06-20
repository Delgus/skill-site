<?php

class HomeCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/site/index');
    }

    public function contentOnHomePage(AcceptanceTester $I)
    {

        $I->seeInTitle('Прокачайся!!!');
        $I->seeLink('Перейти к блогу');
        $I->seeLink('Приступить к тестам');

    }

    public function blogButton(AcceptanceTester $I)
    {
        $I->click('Перейти к блогу');
        $I->seeInTitle('Блог');
    }

    public function blogTest(AcceptanceTester $I)
    {
        $I->click('Приступить к тестам');
        $I->seeInTitle('Авторизация');
    }
}
