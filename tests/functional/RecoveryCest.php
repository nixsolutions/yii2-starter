<?php


class RecoveryCest
{

    public function seeRecoveryPage(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);
        $I->click('Forgot password?');
        $I->seeResponseCodeIs(200);
        $I->see('Password recovery');
        $I->see('Email');
        $I->see('Send');
    }

    public function sendRecoveryOnEmptyEmail(FunctionalTester $I)
    {
        $I->amOnPage('/recovery');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#recovery-form',[
            'RecoveryForm[email]' => '',
        ]);
        $I->expectTo('see error message');
        $I->see('Email cannot be blank.');
    }

    public function sendRecoveryOnNotValidEmail(FunctionalTester $I)
    {
        $I->amOnPage('/recovery');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#recovery-form',[
            'RecoveryForm[email]' => 'admin',
        ]);
        $I->expectTo('see error message');
        $I->see('Email is not a valid email address.');
    }

    public function sendRecoveryOnCorrectEmail(FunctionalTester $I)
    {
        $I->amOnPage('/recovery');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#recovery-form',[
            'RecoveryForm[email]' => 'admin@admin.com',
        ]);
        $I->expectTo('see success message');
        $I->seeResponseCodeIs(200);
        $I->see('Please check your email and follow instructions to recover password.');
    }

    public function seeChangePasswordPage(FunctionalTester $I)
    {
        $I->amOnRoute('/user/auth/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->see('Password changing');
        $I->see('New password');
        $I->see('Repeat password');
        $I->see('Save');
    }

    public function changePasswordWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnPage('/user/auth/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '',
            'ChangePasswordForm[repeatPassword]' => '',
        ]);
        $I->expectTo('see error message');
        $I->see('New password cannot be blank.');
        $I->see('Repeat password cannot be blank.');
    }

    public function changePasswordWithShortPassword(FunctionalTester $I)
    {
        $I->amOnRoute('/user/auth/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '1111',
            'ChangePasswordForm[repeatPassword]' => '222222',
        ]);
        $I->expectTo('see error message');
        $I->see('New password should contain at least 6 characters.');
    }

    public function changePasswordWithDifferentPasswords(FunctionalTester $I)
    {
        $I->amOnRoute('/user/auth/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '111111',
            'ChangePasswordForm[repeatPassword]' => '222222',
        ]);
        $I->expectTo('see error message');
        $I->see('Passwords don\'t match.');
    }

    public function changePasswordWithCorrectPasswords(FunctionalTester $I)
    {
        $I->amOnRoute('/user/auth/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '111111',
            'ChangePasswordForm[repeatPassword]' => '111111',
        ]);
        $I->expectTo('be logged in');
        $I->seeResponseCodeIs(200);
        $I->see('Logout');
    }
}
