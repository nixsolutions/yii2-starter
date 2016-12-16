<?php

use app\tests\functional\BaseFunctionalCest;
use yii\helpers\Url;

class ManagementMailTemplateCest extends BaseFunctionalCest
{
    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeTemplatesList(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mail-template'));
        $I->see('Mail Templates');
        $I->expectTo('See templates greed');
        $I->see('Name');
        $I->see('Key');
        $I->see('Subject');
        $I->see('Actions');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateFormWithEmptyName(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/management/update?id=1'));
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

    /**
     * @before loginAsAdmin
     */
    public function updateNotExistTemplate(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/management/update?id=1000'));
        $I->seeResponseCodeIs(404);
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateFormSuccessful(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/management/update?id=1'));
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

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeTemplateDescription(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/management/view?id=1'));
        $I->seeResponseCodeIs(200);

        $I->expectTo('see full template descriptions');
        $I->see('Name');
        $I->see('Key');
        $I->see('Subject');
        $I->see('Updated At');
    }

    /**
     * @before loginAsUser
     */
    public function tryUpdateNotAdmin(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailTemplate/management/view?id=1'));
        $I->seeResponseCodeIs(403);
    }
}
