<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\ServerErrorHttpException;

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
 * @property string $auth_provider
 * @property string $social_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    /** Active user status */
    const STATUS_ACTIVE = 'active';

    /** Blocked user status */
    const STATUS_BLOCKED = 'blocked';

    /** Created user status */
    const STATUS_CREATED = 'created';

    /** Role user */
    const ROLE_USER = 'user';

    /** Role admin */
    const ROLE_ADMIN = 'admin';

    const DEFAULT_AVATAR_URL = '/img/no_image.png';

    public $rememberMe = true;

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
            ['email', 'unique'],
            [['created_at', 'last_login_at'], 'safe'],
            [['auth_key', 'avatar', 'email', 'password', 'auth_provider'], 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 64],
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
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * @param $email
     * @return static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
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
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     * @throws Exception
     */
    public function login()
    {
        if (!Yii::$app->user->login($this, $this->rememberMe ? 3600 * 24 * 7 : 0)) {
            throw new Exception('User could not be logged in.');
        }
        $this->last_login_at = date('Y-m-d H:i:s');
        $this->update();
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
        $this->avatar = self::DEFAULT_AVATAR_URL;

        $this->save();
        $this->setRole(self::ROLE_USER);
        return $this;
    }

    /**
     * Set new role
     *
     * @param $role
     */
    public function setRole($role)
    {
        $auth = Yii::$app->authManager;
        $auth->revokeAll($this->id);
        $userRole = $auth->getRole($role);
        $auth->assign($userRole, $this->getId());
    }

    /**
     * Return role for user
     *
     * @return string
     */
    public function getRoleName()
    {
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRolesByUser($this->id);
        return !empty($userRole) ? array_shift($userRole)->name : '';
    }

    /**
     * @param $hash
     * @return static
     * @throws ServerErrorHttpException
     */
    public static function findByHash($hash)
    {
        if (!$hash = Hash::findOne(['hash' => $hash])) {
            throw new ServerErrorHttpException('The server encountered an internal error and could not complete your request.');
        }
        return static::findOne($hash->user_id);
    }

    /**
     * @param $socialId
     * @return static
     */
    public static function findBySocialId($socialId)
    {
        return static::findOne(['social_id' => $socialId]);
    }

    /**
     * @param $userAttributes
     * @return bool
     */
    public function saveSocialAccountInfo($userAttributes)
    {
        $this->first_name = ArrayHelper::getValue($userAttributes, 'firstName');
        $this->last_name = ArrayHelper::getValue($userAttributes, 'lastName');
        $this->email = ArrayHelper::getValue($userAttributes, 'email');
        $this->social_id = ArrayHelper::getValue($userAttributes, 'socialId');
        $this->avatar = ArrayHelper::getValue($userAttributes, 'avatar');
        $this->status = self::STATUS_ACTIVE;
        $this->auth_provider = ArrayHelper::getValue($userAttributes, 'authProvider');

        return $this->save();
    }
}
