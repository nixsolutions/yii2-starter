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
 *
 * @package app\modules\user\models\forms
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $password
 * @property string $passwordRepeat
 */
class RegistrationForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $passwordRepeat;
    public $avatar;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            'emailUnique' => [
                'email',
                'unique',
                'targetClass' => new User(),
                'message' => Yii::t('user', 'This email has already been taken.')
            ],
            [['firstName', 'lastName', 'password', 'passwordRepeat', 'email'], 'required'],
            ['email', 'string'],
            ['email', 'email'],
            [['firstName', 'lastName'], 'string', 'max' => 64],
            ['password', 'string', 'min' => 6, 'max' => 32],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match."],
            ['avatar', 'string', 'max' => '255'],
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
