<?php

namespace app\tests\functional;

use FunctionalTester;

class BaseFunctionalCest
{
    protected function loginAsAdmin(FunctionalTester $I)
    {
        $I->amOnRoute('/login');
        $I->seeInTitle('Login');
        $I->amLoggedInAs(1);
    }

    protected function loginAsUser(FunctionalTester $I)
    {
        $I->amOnRoute('/login');
        $I->seeInTitle('Login');
        $I->amLoggedInAs(2);
    }

    protected function logout(FunctionalTester $I)
    {
        $I->click('.btn.btn-link.logout');
        $I->amOnPage('/');
        $I->see('Login', 'a');
    }

}
