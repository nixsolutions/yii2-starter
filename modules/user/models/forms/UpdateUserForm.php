<?php

namespace app\modules\user\models\forms;

use app\modules\user\models\AuthAssignment;
use app\modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * UpdateUserForm is the model behind the update user.
 *
 * @property string $firstName
 * @property string $lastName
 * @property string $email
 * @property string $status
 * @property string $role
 *
 * @package app\modules\user\models\forms
 */
class UpdateUserForm extends Model
{
    /** @var integer */
    public $id = null;

    /** @var string */
    public $firstName = '';

    /** @var string */
    public $lastName = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $status = '';

    /** @var string */
    public $role = '';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id' => 'id'],
            ],
            [['firstName', 'lastName', 'email', 'role'], 'required'],
            ['email', 'email'],
            ['email', 'string'],
            [['firstName', 'lastName'], 'string', 'max' => 64],
            [['status'], 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_BLOCKED, User::STATUS_CREATED]],
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
        ];
    }

    /**
     * Save data to User and AuthAssignment tables
     *
     * @return $this
     */
    public function update()
    {
        $user = User::findOne(['id' => $this->id]);
        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->email = $this->email;
        $user->save(false);

        $role = $this->getRole();
        $role->item_name = $this->role;
        $role->save(false);
        return $this;
    }

    /**
     * Return existing role for updating or create new
     *
     * @return AuthAssignment
     */
    private function getRole()
    {
        $role = AuthAssignment::findOne(['user_id' => $this->id]);
        if (null == $role) {
            $role = new AuthAssignment();
            $role->user_id = $this->id;
        }
        return $role;
    }
}
