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
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
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
            [['email'], 'required'],
            [['message', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
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
            'id' => Yii::t('feedback', 'ID'),
            'name' => Yii::t('feedback', 'Name'),
            'email' => Yii::t('feedback', 'Email'),
            'message' => Yii::t('feedback', 'Message'),
            'status' => Yii::t('feedback', 'Status'),
            'created_at' => Yii::t('feedback', 'Created At'),
            'updated_at' => Yii::t('feedback', 'Updated At'),
        ];
    }
}
