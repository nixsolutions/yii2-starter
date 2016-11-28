<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Class Mail
 *
 * How to use
 *
 * if (!$mailTemplate = MailTemplate::findByKey('REGISTER')) {
 * throw new NotFoundHttpException('Template not found in database');
 * }
 * $mailTemplate->replacePlaceholders([
 * 'user' => 'vasia',
 * 'link' => 'https://www.google.com.ua',
 * 'password' => 'qwerty
 * ]);
 *
 * $sendMail = new Mail();
 * $sendMail->setTemplate($mailTemplate);
 * $sendMail->sendTo('goodeveningproj@gmail.com');
 *
 * @package app\modules\mailTemplate\models
 */
class Mail extends Model
{
    /**
     * @var MailTemplate
     */
    protected $template = null;

    const FROM_NAME = 'Yii starter';
    const FROM_EMAIL = 'admin@example.com';
    /**
     * Set template
     *
     * @param MailTemplate $template
     * @return $this
     */
    public function setTemplate(MailTemplate $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Send mail to user
     *
     * @param $emailTo
     * @return bool
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function sendTo($emailTo)
    {
        if (null === $this->template) {
            throw new NotFoundHttpException(Yii::t('mailTemplate', 'Template does not exist.'));
        }
        $fromName = ArrayHelper::getValue(Yii::$app->params, 'mail.fromName', self::FROM_NAME);
        $fromEmail = ArrayHelper::getValue(Yii::$app->params, 'mail.fromEmail', self::FROM_EMAIL);

        Yii::$app->mailer->compose()
            ->setTo($emailTo)
            ->setFrom([$fromEmail => $fromName])
            ->setSubject($this->template->subject)
            ->setHtmlBody($this->template->body)
            ->send();
    }
}
