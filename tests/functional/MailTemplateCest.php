<?php

use app\tests\fixtures\MailTemplateFixture;
use yii\helpers\Url;

class MailTemplateCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/login');
        $I->amLoggedInAs(1);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seeTemplatesList(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate'));
        $I->see('Mail Templates');
        $I->expectTo('See templates greed');
        $I->see('Name');
        $I->see('Key');
        $I->see('Subject');
        $I->see('Actions');
    }

    public function updateFormWithEmptyName(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/template/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->submitForm('#mailTemplateForm', [
            'MailTemplate[name]' => '',
            'MailTemplate[subject]' => 'test',
            'MailTemplate[key]' => 'test key',
            'MailTemplate[body]' => 'test body',
        ]);
        $I->expectTo('see that name cannot be blank');
        $I->see('Name cannot be blank.');
    }

    public function updateNotExistTemplate(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/template/update?id=1000'));
        $I->seeResponseCodeIs(404);
    }

    public function updateFormSuccessful(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/template/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->submitForm('#mailTemplateForm', [
            'MailTemplate[name]' => 'test name',
            'MailTemplate[subject]' => 'test',
            'MailTemplate[key]' => 'test key',
            'MailTemplate[body]' => 'test body',
        ]);
        $I->expectTo('see that template updated successful');
        $I->see('test name');
    }

    public function seeTemplateDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/template/view?id=1'));
        $I->seeResponseCodeIs(200);

        $I->expectTo('see full template descriptions');
        $I->see('Name');
        $I->see('Key');
        $I->see('Subject');
        $I->see('Updated At');
    }
}
