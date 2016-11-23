<?php

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "hash".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $hash
 * @property string $type
 */
class Hash extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hashes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['type'], 'string'],
            [['hash'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'hash' => 'Hash',
            'type' => 'Type',
        ];
    }

    public function create($user_id)
    {
        $this->user_id = $user_id;
        $this->hash = Yii::$app->security->generateRandomString();
        $this->save();
        return $this->hash;
    }
}
