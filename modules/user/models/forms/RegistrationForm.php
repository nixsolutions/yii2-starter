<?php
/**
 * Created by PhpStorm.
 * User: zmievskaya
 * Date: 18.11.16
 * Time: 16:31
 */

namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use Yii;
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
            ['passwordRepeat', 'compare', 'compareAttribute'=>'password', 'message' => "Passwords don't match"],
            ['verifyCode', 'captcha', 'captchaAction' => 'user/auth/captcha',],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            return $user->create($this);
        }
    }
}
