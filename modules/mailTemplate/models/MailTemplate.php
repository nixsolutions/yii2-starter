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
            [['name'], 'string', 'max' => 250],
            [['key', 'subject'], 'string', 'max' => 255],
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
     * Find template by key
     *
     * @param $key
     * @return $this|null
     */
    public static function findByKey($key)
    {
        return static::find()->where(['key' => $key])->one();
    }

    /**
     * Replace placeholders in template to concrete data
     *
     * @param $placeholders array
     * @return string
     */
    public function replacePlaceholders(array $placeholders)
    {
        foreach ($this->getPlaceholdersList() as $placeholderName) {
            $this->body = str_replace("{{$placeholderName}}", $placeholders[$placeholderName], $this->body);
        }
    }

    /**
     * Return array with placeholders name
     *
     * @return array
     */
    protected function getPlaceholdersList()
    {
        return (array)$this->placeholdersList;
    }
}
