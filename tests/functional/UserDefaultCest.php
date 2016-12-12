<?php

use yii\helpers\Url;

class UserDefaultCest
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

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeUserDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->expectTo('see information about user');
        $I->see('admin', 'td');
        $I->see('admin@admin.com', 'td');
        $I->see('active', 'td');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeUpdateButton(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'a');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateUserInfoSuccess(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UserForm[first_name]' => 'test name',
            'UserForm[last_name]' => 'test',
        ]);
        $I->expectTo('see that user info updated successful');
        $I->see('test name');
        $I->see('test');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateUserWithWrongData(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UserForm[first_name]' => '',
            'UserForm[last_name]' => '',
        ]);
        $I->expectTo('see validation errors');
        $I->see('First name cannot be blank.');
        $I->see('Last name cannot be blank.');
    }

    /**
     * @before loginAsUser
     * @after logout
     */
    public function seeUserDescriptionAsUser(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->expectTo('see information about user');
        $I->see('user', 'td');
        $I->see('user@user.com', 'td');
        $I->see('active', 'td');
    }
}
