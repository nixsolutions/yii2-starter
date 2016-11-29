<?php

namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['email', 'email']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'rememberMe' => Yii::t('user', 'Remember me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email);

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }
}
