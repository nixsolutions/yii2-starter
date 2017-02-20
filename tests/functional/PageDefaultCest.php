<?php

class PageDefaultCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seePageAbout(FunctionalTester $I)
    {
        $I->wantToTest('static page about');
        $I->expectTo('see about page');
        $I->amOnRoute('/about.html');
        $I->see('About');
    }

    public function tryToSeeNotExistingPage(FunctionalTester $I)
    {
        $I->amGoingTo('try to see not existing static page');
        $I->expectTo('see Not Found error');
        $I->amOnRoute('/test.html');
        $I->see('The requested page does not exist.');
    }
}
