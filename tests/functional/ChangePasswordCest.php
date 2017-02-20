<?php

use app\tests\functional\BaseFunctionalCest;
use yii\helpers\Url;

class ChangePasswordCest extends BaseFunctionalCest
{
    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeUserProfile(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->see('Change password');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function sendChangePasswordMail(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->click('Change password');
        $I->expectTo('see success message');
        $I->seeResponseCodeIs(200);
        $I->see('Please check your email and follow instructions to change your password.');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeChangePasswordPage(FunctionalTester $I)
    {
        $I->amOnRoute('/user/default/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->see('Password changing');
        $I->see('New password');
        $I->see('Repeat password');
        $I->see('Save');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function changePasswordWithEmptyFields(FunctionalTester $I)
    {
        $I->amOnPage('/user/default/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '',
            'ChangePasswordForm[repeatPassword]' => '',
        ]);
        $I->expectTo('see error message');
        $I->see('New password cannot be blank.');
        $I->see('Repeat password cannot be blank.');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function changePasswordWithShortPassword(FunctionalTester $I)
    {
        $I->amOnRoute('/user/default/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '1111',
            'ChangePasswordForm[repeatPassword]' => '222222',
        ]);
        $I->expectTo('see error message');
        $I->see('New password should contain at least 6 characters.');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function changePasswordWithDifferentPasswords(FunctionalTester $I)
    {
        $I->amOnRoute('/user/default/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '111111',
            'ChangePasswordForm[repeatPassword]' => '222222',
        ]);
        $I->expectTo('see error message');
        $I->see('Passwords don\'t match.');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function changePasswordWithCorrectPasswords(FunctionalTester $I)
    {
        $I->amOnRoute('/user/default/change-password?hash=1111');
        $I->seeResponseCodeIs(200);
        $I->submitForm('#change-password-form',[
            'ChangePasswordForm[newPassword]' => '111111',
            'ChangePasswordForm[repeatPassword]' => '111111',
        ]);
        $I->seeResponseCodeIs(200);
    }
}
