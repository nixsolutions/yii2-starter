<?php


use yii\helpers\Url;

class ManagementOptionCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/login');
        $I->amLoggedInAs(1);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seeOptionsGrid(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/options'));
        $I->seeResponseCodeIs(200);
        $I->see('Options');
        $I->expectTo('See options greed');
        $I->see('Namespace');
        $I->see('Key');
        $I->see('Value');
        $I->see('Description');
        $I->see('Created At');
        $I->see('Updated At');
        $I->see('Actions');
    }

    public function seeOptionsFromDatabase(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/options'));
        $I->seeResponseCodeIs(200);
        $I->see('ADMIN', 'td');
        $I->see('email', 'td');
        $I->see('admin@mail.com', 'td');
        $I->see('Must contains admin email', 'td');
        $I->see('2016-12-10 09:30:43', 'td');
        $I->see('2016-12-10 09:30:43', 'td');
    }

    public function seeOptionDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/option/management/view?namespace=ADMIN&key=email'));
        $I->seeResponseCodeIs(200);
        $I->expectTo('see information about option');
        $I->see('ADMIN', 'td');
        $I->see('email', 'td');
        $I->see('admin@mail.com', 'td');
        $I->see('Must contains admin email', 'td');
        $I->see('2016-12-10 09:30:43', 'td');
        $I->see('2016-12-10 09:30:43', 'td');
    }

    public function seeUpdateButton(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/option/management/view?namespace=ADMIN&key=email'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'a');
    }

    public function updateOptionSuccess(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/option/management/update?namespace=ADMIN&key=email'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#optionForm', [
            'Option[value]' => 'new.admin@mail.com',
        ]);
        $I->expectTo('see that option value updated successful');
        $I->see('new.admin@mail.com', 'td');
    }

    public function tryUpdateOptionReadonlyField(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/option/management/update?namespace=ADMIN&key=email'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('#optionForm', [
            'Option[value]' => 'new.admin@mail.com',
            'Option[key]' => 'someKey',
        ]);
        $I->expectTo('see that option info not updated');
        $I->see('new.admin@mail.com', 'td');
        $I->see('email', 'td');
    }

}
