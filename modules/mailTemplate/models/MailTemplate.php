<?php

namespace app\modules\mailTemplate\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "mail_template".
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
    /** @var array Placeholders list */
    protected $placeholdersList = ['user', 'data', 'link', 'password'];

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
        return 'mail_template';
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
            [['key', 'subject', 'name'], 'string', 'max' => 255],
            [['key'], 'unique']
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
     * @throws \Exception
     */
    public function replacePlaceholders(array $placeholders)
    {
        foreach ($placeholders as $placeholderName => $value) {
            if (!in_array($placeholderName, $this->placeholdersList)) {
                throw new \Exception("Getting unknown placeholders name: $placeholderName");
            }
            $this->body = str_replace("{{$placeholderName}}", $value, $this->body);
        }
    }
}
