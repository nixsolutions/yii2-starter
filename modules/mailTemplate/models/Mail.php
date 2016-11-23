<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class Mail
 *
 * How to use
 *
    if (!$mailTemplate = MailTemplate::findByKey('REGISTER')) {
        throw new NotFoundHttpException('Template not found in database');
    }
    $mailTemplate->replacePlaceholders([
        'user' => 'vasia',
        'link' => 'https://www.google.com.ua',
        'password' => 'qwerty
    ]);

    $sendMail = new Mail();
    $sendMail->setTemplate($mailTemplate);
    $sendMail->sendTo('goodeveningproj@gmail.com');
 *
 * @package app\modules\mailTemplate\models
 */
class Mail extends Model
{
    /**
     * @var MailTemplate
     */
    protected $template = null;

    /**
     * Set template
     *
     * @param MailTemplate $template
     */
    public function setTemplate(MailTemplate $template)
    {
        $this->template = $template;
    }

    /**
     * Send mail to user
     *
     * @param $emailTo
     * @return bool
     * @throws \Exception
     */
    public function sendTo($emailTo)
    {
        if (null === $this->template) {
            throw new \Exception('First set template instance of class \app\modules\mailTemplate\models\MailTemplate');
        }
        $fromName = ArrayHelper::getValue(Yii::$app->params, 'mail.fromName', 'Yii starter');
        $fromEmail = ArrayHelper::getValue(Yii::$app->params, 'mail.fromEmail', 'admin@example.com');
        try {
            Yii::$app->mailer->compose()
                ->setTo($emailTo)
                ->setFrom([$fromEmail => $fromName])
                ->setSubject($this->template->subject)
                ->setHtmlBody($this->template->body)
                ->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
