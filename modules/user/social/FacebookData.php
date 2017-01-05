<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class FacebookData
 * @package app\modules\user\social
 */
class FacebookData
{
    private static $client;

    /**
     * @param mixed $client
     */
    public static function setClient($client)
    {
        self::$client = $client;
    }

    /**
     * @return array
     */
    public static function normalizeUserAttributeMap()
    {
        return [
            'firstName' => function ($attributes) {
                return explode(' ', ArrayHelper::getValue($attributes, 'name'))[0];
            },
            'lastName' => function ($attributes) {
                return explode(' ', ArrayHelper::getValue($attributes, 'name'))[1];
            },
            'email' => 'email',
            'socialId' => 'id',
            'avatar' => function ($attributes) {
                return self::$client->apiBaseUrl . ArrayHelper::getValue($attributes, 'id') . '/picture?type=large';
            },
        ];
    }
}