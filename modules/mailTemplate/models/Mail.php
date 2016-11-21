<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\base\Model;

class Mail extends Model
{
    public $email;

    /** @var Placeholders */
    public $placeholders = null;

    /** @var MailTemplate */
    public $template = null;

    public function rules()
    {
        return [
            [['placeholders', 'template'], 'required'],
            ['placeholders', function ($attribute, $params) {
                if (!$this->$attribute instanceof \app\modules\mailTemplate\models\Placeholders) {
                    $this->addError(
                        $attribute,
                        "$attribute must be instance of \\app\\modules\\mailTemplate\\models\\Placeholders"
                    );
                }
            }],
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
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($emailTo)
                ->setFrom([Yii::$app->params['adminEmail'] => 'Yii2 starter'])
                ->setSubject($this->template->subject)
                ->setHtmlBody($this->getBody())
                ->send();

            return true;
        }
        return false;
    }

    /**
     * Replace placeholders in template to concrete data
     *
     * @return string
     */
    private function getBody()
    {
        $body = $this->template->body;
        foreach ($this->placeholders as $name => $placeholder) {
            $body = str_replace("{{$name}}", $placeholder, $body);
        }
        return $body;
    }
}
