<?php

namespace app\modules\mailTemplate\models;

use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class Mail
 *
 * How to use
 *
 * if (!$mailTemplate = MailTemplate::findByKey('YOUR_KEY')) {
 * throw new NotFoundHttpException('Template not found in database.');
 * }
 * $mailTemplate->replacePlaceholders([
 * 'key1' => 'value1',
 * 'key2' => 'value2',
 * 'key3' => 'value3',
 * ]);
 *
 * $sendMail = new Mail();
 * $sendMail->setTemplate($mailTemplate);
 * $sendMail->sendTo('recipient@gmail.com');
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
     * @throws InvalidConfigException
     * @throws MailNotSendException
     */
    public function sendTo($emailTo)
    {
        if (null === $this->template) {
            throw new InvalidConfigException('Template does not exist. First set template.');
        }
        $fromName = ArrayHelper::getValue(Yii::$app->params, 'mail.fromName', self::FROM_NAME);
        $fromEmail = ArrayHelper::getValue(Yii::$app->params, 'mail.fromEmail', self::FROM_EMAIL);

        try {
            Yii::$app->mailer->compose()
                ->setTo($emailTo)
                ->setFrom([$fromEmail => $fromName])
                ->setSubject($this->template->subject)
                ->setHtmlBody($this->template->body)
                ->send();
        } catch (Exception $e) {
            throw new MailNotSendException("Cannot send email to $emailTo.", $e->getCode(), $e);
        }
    }
}
