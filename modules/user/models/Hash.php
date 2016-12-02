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
    const TYPE_REGISTER = 'register';
    const TYPE_RECOVER = 'recover';

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

    /**
     * @param $type
     * @param $userId
     * @return string
     */
    public function generate($type, $userId)
    {
        if (($hash = self::findByUserId($userId)) && ($type == $hash->type)) {
            $hash->delete();
        }
        $this->user_id = $userId;
        $this->hash = Yii::$app->security->generateRandomString();
        $this->type = $type;
        $this->save();

        return $this->hash;
    }

    /**
     * Finds hash by userId
     *
     * @param $userId
     * @return static
     */
    public static function findByUserId($userId)
    {
        return static::findOne(['user_id' => $userId]);
    }
}
