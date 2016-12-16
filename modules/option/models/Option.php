<?php

namespace app\modules\option\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property string $namespace
 * @property string $key
 * @property string $value
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['namespace', 'key'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['namespace', 'key', 'value', 'description'], 'string', 'max' => 255],
            [['namespace', 'key'],
                'unique',
                'targetAttribute' => ['namespace', 'key'],
                'message' => 'The combination of Namespace and Key has already been taken.',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'namespace' => Yii::t('option', 'Namespace'),
            'key' => Yii::t('option', 'Key'),
            'value' => Yii::t('option', 'Value'),
            'description' => Yii::t('option', 'Description'),
            'created_at' => Yii::t('option', 'Created At'),
            'updated_at' => Yii::t('option', 'Updated At'),
        ];
    }
}
