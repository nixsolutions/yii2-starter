<?php

namespace app\modules\user\models\forms;

use Yii;
use yii\base\Model;

/**
 * PasswordForm is the model behind the changing password form.
 */
class PasswordForm extends Model
{
    public $newPassword;
    public $repeatPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['newPassword', 'repeatPassword'], 'required'],
            ['newPassword', 'string', 'min' => 6, 'max' => 32],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => "Passwords don't match."],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => Yii::t('user', 'New password'),
            'repeatPassword' => Yii::t('user', 'Repeat password'),
        ];
    }
}
