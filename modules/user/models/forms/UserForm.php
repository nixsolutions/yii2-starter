<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\modules\user\models\User;

/**
 * UserForm is the model behind the update user.
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $status
 * @property string $role
 *
 * @package app\modules\user\models\forms
 */
class UserForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $status;
    public $role;

    const SCENARIO_PROFILE = 'profile';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'role'], 'required'],
            ['email', 'email'],
            ['email', 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 64],
            [
                ['status'], 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_BLOCKED, User::STATUS_CREATED],
                'message' => Yii::t('user', 'Status is invalid.'),
            ],
            [
                ['role'], 'in', 'range' => [User::ROLE_ADMIN, User::ROLE_USER],
                'message' => Yii::t('user', 'Role is invalid.'),
            ],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('user', 'First name'),
            'last_name' => Yii::t('user', 'Last name'),
            'email' => Yii::t('user', 'Email'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios = ArrayHelper::merge($scenarios, [self::SCENARIO_PROFILE => ['first_name', 'last_name', 'email']]);
        return $scenarios;
    }
}
