<?php

namespace app\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $status
 * @property string $created_at
 * @property string $last_login_at
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $rememberMe;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['status'], 'string'],
            ['email', 'email'],
            [['created_at', 'last_login_at'], 'safe'],
            [['auth_key', 'avatar', 'email', 'password'], 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'first_name' => Yii::t('user', 'First name'),
            'last_name' => Yii::t('user', 'Last name'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'avatar' => Yii::t('user', 'Avatar'),
            'status' => Yii::t('user', 'Status'),
            'created_at' => Yii::t('user', 'Registration time'),
            'last_login_at' => Yii::t('user', 'Last sign in'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => date('Y-m-d H:i:s')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * @param $userData
     * @return User
     */
    public function create($userData)
    {
        $this->first_name = $userData->firstName;
        $this->last_name = $userData->lastName;
        $this->email = $userData->email;
        $this->password = Yii::$app->security->generatePasswordHash($userData->password);
        $this->auth_key = Yii::$app->security->generateRandomString();

        $this->save();

        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('user');
        $auth->assign($userRole, $this->getId());

        return $this;
    }

    /**
     * @param $formData
     * @return array|bool
     */
    public function register($formData)
    {
        $user = new User();
        $user->create($formData);

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