<?php

namespace app\modules\page\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property string $content
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends ActiveRecord
{
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
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string'],
            ['title', 'string', 'max' => 64],
            [['key', 'description'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('page', 'ID'),
            'key' => Yii::t('page', 'Key'),
            'title' => Yii::t('page', 'Title'),
            'content' => Yii::t('page', 'Content'),
            'description' => Yii::t('page', 'Description'),
            'created_at' => Yii::t('page', 'Created At'),
            'updated_at' => Yii::t('page', 'Updated At'),
        ];
    }

    /**
     * Find page by key
     *
     * @param $key
     * @return $this|null
     */
    public static function findByKey($key)
    {
        return static::findOne(['key' => $key]);
    }
}
