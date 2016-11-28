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
            throw new NotFoundHttpException('Template does not exist.');
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
            throw $e;
        }
    }
}
