<?php

namespace app\modules\feedback\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $message;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'message'], 'required'],
            ['email', 'email'],
            [['message'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('feedback', 'Verification Code'),
        ];
    }
}
