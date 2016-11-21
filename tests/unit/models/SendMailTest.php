<?php

use app\modules\mailTemplate\models\Mail;
use app\modules\mailTemplate\models\MailTemplate;

class SendMailTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testValidation()
    {
        $mail = new Mail();
        $mail->attributes = [
            'template' => 'some string',
        ];
        $this->assertFalse($mail->validate());

        $mail->attributes = [
            'template' => new MailTemplate(),
        ];
        $this->assertTrue($mail->validate());
    }

    public function testSendingEmail()
    {
        /** @var ContactForm $model */
        $this->model = $this->getMockBuilder('app\modules\mailTemplate\models\Mail')
            ->setMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $template = MailTemplate::findByKey('LOGIN');
        $template->replacePlaceholders([
            'user' => 'vasia',
            'data' => '21.03.2018',
            'link' => 'https://www.google.com.ua',
            'password' => 'qwerty',
        ]);
        $this->model->template = $template;

        expect_that($this->model->sendTo('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('admin@example.com');
        expect($emailMessage->getSubject())->equals('test');
        expect($emailMessage->toString())->contains('Hello vasia');
        expect($emailMessage->toString())->contains('In 21.03.2018');
        expect($emailMessage->toString())->contains('Visit link https://www.google.com.ua');
        expect($emailMessage->toString())->contains('Restore password qwerty');
    }
}
