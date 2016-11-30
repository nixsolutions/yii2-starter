<?php


class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/login');
        $I->seeResponseCodeIs(200);
    }

    public function loginWithEmptyFields(FunctionalTester $I)
    {
        $I->submitForm('#login-form',[
            'LoginForm[email]' => '',
            'LoginForm[password]' => ''
        ]);
        $I->expectTo('see validation error');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithNotValidEmail(FunctionalTester $I)
    {
        $I->submitForm('#login-form',[
            'LoginForm[email]' => 'admin',
            'LoginForm[password]' => 'admin'
        ]);
        $I->expectTo('see validation error');
        $I->see('Email is not a valid email address.');
    }

    public function loginWithCorrectData(FunctionalTester $I)
    {
        $I->submitForm('#login-form',[
            'LoginForm[email]' => 'admin@admin.com',
            'LoginForm[password]' => '123456'
        ]);
        $I->expectTo('see home page');
        $I->see('Logout');
    }
}
