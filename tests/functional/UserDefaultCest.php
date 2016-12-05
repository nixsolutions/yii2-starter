<?php

use yii\helpers\Url;

class UserDefaultCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/login');
        $I->amLoggedInAs(1);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seeUserDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->expectTo('see information about user');
        $I->see('admin', 'td');
        $I->see('admin@admin.com', 'td');
        $I->see('active', 'td');
    }

    public function seeUpdateButton(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/user/default/profile'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'a');
    }


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
}
