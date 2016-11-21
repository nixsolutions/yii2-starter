<?php
/**
 * Created by PhpStorm.
 * User: zmievskaya
 * Date: 18.11.16
 * Time: 16:31
 */

namespace app\modules\user\models\forms;

use app\modules\user\models\Hash;
use app\modules\user\models\User;
use yii\base\Model;

/**
 * Class RegistrationForm
 * @package app\modules\user\models\forms
 */
class RegistrationForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $passwordRepeat;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'password', 'passwordRepeat', 'email', 'verifyCode'], 'required'],
            ['email', 'email'],
            [['email', 'verifyCode'], 'string'],
            [['firstName', 'lastName'], 'string', 'max' => 64],
            ['password', 'string', 'min' => 8, 'max' => 32],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['verifyCode', 'captcha', 'captchaAction' => 'user/auth/captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'passwordRepeat' => 'Repeat password',
            'verifyCode' => 'Verification Code',
        ];
    }


    public function register()
    {
        $user = new User();
        $user->create($this);

        $hash = new Hash();
        if ($hashKey = $hash->create($user->id)) {
            return [
                'user_id' => $user->id,
                'hash' => $hashKey,
            ];
        }
        return false;
    }
}
