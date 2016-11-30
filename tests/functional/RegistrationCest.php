<?php

class RegistrationCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/registration');
    }

    public function seeRegistrationForm(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/registration');
        $I->see('Registration');
        $I->expectTo('see registration form');
        $I->see('First name');
        $I->see('Last name');
        $I->see('Email');
        $I->see('Password');
        $I->see('Repeat password');
    }

    public function registerWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/registration');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#registration-form',[
            'RegistrationForm[firstName]' => '',
            'RegistrationForm[lastName]' => '',
            'RegistrationForm[email]' => '',
            'RegistrationForm[password]' => '',
            'RegistrationForm[passwordRepeat]' => '',
        ]);
        $I->expectTo('see error messages');
        $I->see('First name cannot be blank.');
        $I->see('Last name cannot be blank.');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->see('Repeat password cannot be blank.');
    }

    public function registerWithDifferentPasswords(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/registration');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#registration-form',[
        'RegistrationForm[firstName]' => 'test',
        'RegistrationForm[lastName]' => 'test',
        'RegistrationForm[email]' => 'test@test.com',
        'RegistrationForm[password]' => '123456',
        'RegistrationForm[passwordRepeat]' => '234567',
    ]);
        $I->expectTo('see error message');
        $I->see('Passwords don\'t match');
    }

    public function registerWithCorrectData(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/registration');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#registration-form',[
        'RegistrationForm[firstName]' => 'test',
        'RegistrationForm[lastName]' => 'test',
        'RegistrationForm[email]' => 'test@test.com',
        'RegistrationForm[password]' => '123456',
        'RegistrationForm[passwordRepeat]' => '123456',
    ]);
        $I->expectTo('see success message');
        $I->see('Please, check your email to confirm registration.');
    }
}
