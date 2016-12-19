<?php

namespace app\modules\feedback\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $message
 */
class Feedback extends ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_ANSWERED = 'answered';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'required'],
            [['message'], 'string'],
            [
                ['status'], 'in', 'range' => [self::STATUS_ANSWERED, self::STATUS_NEW],
                'message' => Yii::t('feedback', 'Status is invalid.'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'name' => Yii::t('site', 'Name'),
            'email' => Yii::t('site', 'Email'),
            'message' => Yii::t('site', 'Message'),
        ];
    }
}
