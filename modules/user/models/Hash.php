<?php

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

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
    const TYPE_CHANGE_PASSWORD = 'change password';

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
        if ($hash = self::findOne(['user_id' => $userId])) {
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
     * @throws NotFoundHttpException
     */
    public static function findByUserId($userId)
    {
        if (!$hash = Hash::findOne(['user_id' => $userId])) {
            throw new NotFoundHttpException('Hash does not exist.');
        }
        return $hash;
    }
}
