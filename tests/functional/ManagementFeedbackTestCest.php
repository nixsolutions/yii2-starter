<?php

use app\tests\functional\BaseFunctionalCest;
use yii\helpers\Url;

class ManagementFeedbackTestCest extends BaseFunctionalCest
{
    public function seeContactForm(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/contact'));
        $I->seeResponseCodeIs(200);
        $I->see('Create Feedback');
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/contact'));
        $I->submitForm('#contact-form', []);
        $I->expectTo('see validations errors');
        $I->see('Create Feedback', 'h1');
        $I->see('Email cannot be blank');
        $I->see('The verification code is incorrect.');
    }

    public function feedbackAsGuestSuccessfully(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/contact'));
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[message]' => 'test subject',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }

    public function feedbackAsGuestWrongCaptcha(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/contact'));
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[message]' => 'test subject',
            'ContactForm[verifyCode]' => 'wrong world',
        ]);
        $I->see('The verification code is incorrect.');
    }

    /**
     * @before loginAsUser
     * @after logout
     */
    public function feedbackAsUserSuccessfully(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/contact'));
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[message]' => 'test subject',
            'ContactForm[verifyCode]' => 'testme',
        ]);
        $I->see('Thank you for contacting us. We will respond to you as soon as possible.');
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/contact'));
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[message]' => 'test subject',
        ]);
        $I->expectTo('see that email address is wrong');
        $I->dontSee('Name cannot be blank', '.help-inline');
        $I->see('Email is not a valid email address.');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeFeedbackGrid(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/feedback'));
        $I->seeResponseCodeIs(200);
        $I->see('Name');
        $I->see('Email');
        $I->see('Message');
        $I->see('Status');
        $I->see('Created at');
        $I->see('Updated at');
        $I->see('Actions');
        $I->see('Test');
        $I->see('yii2starter@gmail.com');
        $I->see('All great!');
        $I->see('new');
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function seeFeedback(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/feedback/management/view?id=1'));
        $I->seeResponseCodeIs(200);
        $I->see('Test');
        $I->see('yii2starter@gmail.com');
        $I->see('All great!');
        $I->see('new');
    }

    /**
     * @before loginAsAdmin
     */
    public function seeFeedbackNotExistFeedback(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/feedback/management/view?id=10000'));
        $I->seeResponseCodeIs(404);
    }

    /**
     * @before loginAsAdmin
     * @after logout
     */
    public function updateStatusFeedbackSuccess(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/feedback'));
        $I->seeResponseCodeIs(200);
        $I->submitForm('.form-button-inline', []);
        $I->see('Information saved.');
    }
}
