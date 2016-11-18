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
 * @property string $name
 * @property string $created_at
 * @property string $subject
 */
class MailTemplate extends ActiveRecord
{
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
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mailTemplate', 'ID'),
            'body' => Yii::t('mailTemplate', 'Body'),
            'name' => Yii::t('mailTemplate', 'Name'),
            'created_at' => Yii::t('mailTemplate', 'Created At'),
            'subject' => Yii::t('mailTemplate', 'Subject'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function getHtmlBody()
    {
        ob_start();
        echo $this->body;
        return ob_get_clean();
    }
}
