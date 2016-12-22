<?php


use yii\helpers\Url;

class ManagementPageCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/login');
        $I->amLoggedInAs(1);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seePagesGrid(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/page/management/index'));
        $I->seeResponseCodeIs(200);
        $I->see('Static Pages');
        $I->expectTo('See static pages grid');
        $I->see('Key');
        $I->see('Title');
        $I->see('Content');
        $I->see('Description');
        $I->see('Updated at');
        $I->see('about', 'tbody td');
    }

    public function seeUpdateButton(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/page/management/view?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'a');
    }

    public function tryToUpdateNotExistingPage(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/page/management/update?id=1000'));
        $I->seeResponseCodeIs(404);
    }

    public function updateStaticPageSuccess(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/page/management/update?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Update', 'button');
        $I->submitForm('.page-form', [
            'Page[title]' => 'test title',
            'Page[content]' => 'test',
            'Page[description]' => 'test page',
        ]);
        $I->expectTo('see that static page updated successfully');
        $I->see('test title');
        $I->see('test');
        $I->see('test page');
        $I->amOnPage(Url::toRoute('/about.html'));
        $I->see('test title');
        $I->see('test');
    }
}
