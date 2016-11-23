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
            [['firstName', 'lastName', 'password', 'passwordRepeat', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'string'],
            [['firstName', 'lastName'], 'string', 'max' => 64],
            ['password', 'string', 'min' => 6, 'max' => 32],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'firstName' => Yii::t('user', 'First name'),
            'lastName' => Yii::t('user', 'Last name'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'passwordRepeat' => Yii::t('user', 'Repeat password'),
        ];
    }
}
