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
        $this->tester->expectException(\Exception::class, function () {
            $mail = new Mail();
            $mail->sendTo('admin@example.com');
        });
    }

    public function testTrySetPlaceholderNotExistInTemplate()
    {
        /** @var Mail $model */
        $this->model = $this->getMockBuilder('app\modules\mailTemplate\models\Mail')
            ->setMethods(['validate'])
            ->getMock();

        $template = MailTemplate::findByKey('REGISTER');
        $template->replacePlaceholders(['user name' => 'vasia']);
        $this->model->setTemplate($template);
        expect_that($this->model->sendTo('admin@example.com'));
    }

    public function testSendingEmail()
    {
        /** @var Mail $model */
        $this->model = $this->getMockBuilder('app\modules\mailTemplate\models\Mail')
            ->setMethods(['validate'])
            ->getMock();

        $template = MailTemplate::findByKey('REGISTER');
        $template->replacePlaceholders([
            'user' => 'vasia',
            'data' => '21.03.2018',
            'link' => 'https://www.google.com.ua',
            'password' => 'qwerty',
        ]);
        $this->model->setTemplate($template);
        expect_that($this->model->sendTo('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('admin@example.com');
        expect($emailMessage->getSubject())->equals('Test regisret user');
        expect($emailMessage->toString())->contains('Hello vasia');
        expect($emailMessage->toString())->contains('In 21.03.2018');
        expect($emailMessage->toString())->contains('Visit link https://www.google.com.ua');
        expect($emailMessage->toString())->contains('Restore password qwerty');
    }
}
