<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mail_templates".
 *
 * @property integer $id
 * @property string $body
 * @property string $key
 * @property string $name
 * @property string $updated_at
 * @property string $subject
 */
class MailTemplate extends ActiveRecord
{
    const REGISTER_CONFIRM = 'REGISTER_CONFIRM';

    const FORGOT_PASSWORD = 'FORGOT_PASSWORD';

    const CHANGE_PASSWORD = 'CHANGE_PASSWORD';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['name',], 'required'],
            [['updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mailTemplate', 'ID'),
            'key' => Yii::t('mailTemplate', 'Key'),
            'body' => Yii::t('mailTemplate', 'Body'),
            'name' => Yii::t('mailTemplate', 'Name'),
            'updated_at' => Yii::t('mailTemplate', 'Updated At'),
            'subject' => Yii::t('mailTemplate', 'Subject'),
        ];
    }

    /**
     * Find template by key
     *
     * @param $key
     * @return $this|null
     */
    public static function findByKey($key)
    {
        return static::findOne(['key' => $key]);
    }

    /**
     * Replace placeholders in template to concrete data
     *
     * @param array $placeholders
     */
    public function replacePlaceholders(array $placeholders)
    {
        foreach ($placeholders as $placeholderName => $value) {
            $this->body = str_replace("{{{$placeholderName}}}", $value, $this->body);
        }
    }
}
