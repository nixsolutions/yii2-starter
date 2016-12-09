<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property string $email
 * @property string $password
 * @property boolean $rememberMe
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
     * Logs in a provided user.
     *
     * @param $user
     * @throws Exception
     */
    public function login($user)
    {
        if (!Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 7 : 0)) {
            throw new Exception('User could not be logged in.');
        }
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->update();
    }
}
