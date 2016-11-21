<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\base\Model;

class Mail extends Model
{
    /** @var MailTemplate */
    public $template = null;

    /** @var string */
    public $fromName = 'Yii2 application';

    /** @var string */
    public $fromEmail = 'admin@example.com';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template'], 'required'],
            ['template', function ($attribute, $params) {
                if (!$this->$attribute instanceof \app\modules\mailTemplate\models\MailTemplate) {
                    $this->addError(
                        $attribute,
                        "$attribute must be instance of \\app\\modules\\mailTemplate\\models\\MailTemplate"
                    );
                }
            }],
        ];
    }

    /**
     * Send mail to user
     *
     * @param $emailTo
     * @return bool
     */
    public function sendTo($emailTo)
    {
        if (!$this->validate()) {
            return false;
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
