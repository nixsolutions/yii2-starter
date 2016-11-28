<?php

namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;

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

    private $user = false;


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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool|false|int
     * @throws NotFoundHttpException
     */
    public function login()
    {
        if ($this->validate()) {
            if (!$user = $this->getUser()) {
                throw new NotFoundHttpException('User does not exist.');
            }
            if ($user->status == 'active' && Yii::$app->user->login($user, $this->rememberMe ? 3600*24*7 : 0)) {
                $user->last_login_at = date('Y-m-d H:i:s');
                return $user->update();
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('user', 'Your account is not active.'));
            }
        }
        return false;
    }

    /**
     * Finds user by email
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::findByEmail($this->email);
        }
        return $this->user;
    }
}
