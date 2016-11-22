<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\base\Model;

class Mail extends Model
{
    /** @var MailTemplate */
    protected $template = null;

    /** @var string */
    public $fromName = 'Yii2 application';

    /** @var string */
    public $fromEmail = 'admin@example.com';

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
        try {
            Yii::$app->mailer->compose()
                ->setTo($emailTo)
                ->setFrom([$this->fromEmail => $this->fromName])
                ->setSubject($this->template->subject)
                ->setHtmlBody($this->template->body)
                ->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
