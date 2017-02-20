<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;

/**
 * RecoveryForm is the model behind the password recovery form.
 */
class RecoveryForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
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
        ];
    }
}
