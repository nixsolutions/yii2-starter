<?php

namespace app\modules\feedback\models\forms;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $message;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            [['message'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }
}
