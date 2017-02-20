<?php

use app\tests\functional\BaseFunctionalCest;
use yii\helpers\Url;

class ManagementUserCest extends BaseFunctionalCest
{
    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeUsersGrid(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/management/index'));
        $I->seeResponseCodeIs(200);
        $I->see('Users');
        $I->expectTo('See users greed');
        $I->see('First name');
        $I->see('Last name');
        $I->see('Email');
        $I->see('Status');
        $I->see('Registration time');
        $I->see('Last sign in');
        $I->see('Role');
        $I->see('admin', 'tbody td');
        $I->see('admin@admin.com', 'tbody td');
        $I->see('active', 'tbody td');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeUserDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/management/view?id=1'));
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
        $I->amOnPage(Url::toRoute('/user/management/view?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'a');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateUserInfoSuccess(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/management/update?id=2'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UserForm[first_name]' => 'test name',
            'UserForm[last_name]' => 'test',
            'UserForm[status]' => 'created',
            'UserForm[role]' => 'user',
        ]);
        $I->expectTo('see that user info updated successful');
        $I->see('test name');
        $I->see('test');
        $I->see('created');
        $I->see('user');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateUserWithWrongData(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/management/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UserForm[first_name]' => '',
            'UserForm[last_name]' => '',
            'UserForm[status]' => 'created',
            'UserForm[role]' => 'admin',
        ]);
        $I->expectTo('see validation errors');
        $I->see('First name cannot be blank.');
        $I->see('Last name cannot be blank.');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateUserWithWrongStatusAndRole(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/management/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UserForm[first_name]' => 'test',
            'UserForm[last_name]' => 'test',
            'UserForm[status]' => 'error',
            'UserForm[role]' => 'error',
        ]);
        $I->expectTo('see validation errors');
        $I->see('Status is invalid.');
        $I->see('Role is invalid.');
    }

    /**
     * @before loginAsAdmin
     */
    public function tryUpdateNotExistingUser(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/update?id=1000'));
        $I->seeResponseCodeIs(404);
    }

    /**
     * @before loginAsUser
     */
    public function tryUpdateUserNotAdminRole(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/management/update?id=1'));
        $I->seeResponseCodeIs(403);
    }
}
