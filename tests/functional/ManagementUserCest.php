<?php

use yii\helpers\Url;

class ManagementUserCest
{
    public function _before(FunctionalTester $I)
    {
//        $I->amOnRoute('site/login');
//        $I->amLoggedInAs(1);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seeUsersGrid(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/index'));
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

    public function seeUserDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/view?id=1'));
        $I->seeResponseCodeIs(200);
        $I->expectTo('see information about user');
        $I->see('admin', 'td');
        $I->see('admin@admin.com', 'td');
        $I->see('active', 'td');
    }

    public function seeUpdateButton(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/view?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'a');
    }

    public function updateUserInfoSuccess(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UpdateUserForm[firstName]' => 'test name',
            'UpdateUserForm[lastName]' => 'test',
            'UpdateUserForm[email]' => 'test.key@sd.sd',
            'UpdateUserForm[status]' => 'created',
            'UpdateUserForm[role]' => 'admin',
        ]);
        $I->expectTo('see that user info updated successful');
        $I->see('test name');
    }

    public function updateUserWithWrongData(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UpdateUserForm[firstName]' => '',
            'UpdateUserForm[lastName]' => '',
            'UpdateUserForm[email]' => 't',
            'UpdateUserForm[status]' => 'created',
            'UpdateUserForm[role]' => 'admin',
        ]);
        $I->expectTo('see validation errors');
        $I->see('First name cannot be blank.');
        $I->see('Last name cannot be blank.');
        $I->see('Email is not a valid email address.');
    }

    public function updateUserWithWrongStatusAndRole(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#userForm', [
            'UpdateUserForm[firstName]' => 'test',
            'UpdateUserForm[lastName]' => 'test',
            'UpdateUserForm[email]' => 'tss@sds.ss',
            'UpdateUserForm[status]' => 'error',
            'UpdateUserForm[role]' => 'error',
        ]);
        $I->expectTo('see validation errors');
        $I->see('Status is invalid.');
        $I->see('Role is invalid.');
    }

    public function tryUpdateNotExistingUser(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/management/update?id=1000'));
        $I->seeResponseCodeIs(404);
        $I->expectTo('see that page not found');
        $I->see('The requested page does not exist');
    }
}
