<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class FacebookData
 * @package app\modules\user\social
 */
class FacebookData
{
    private $client;

    /**
     * FacebookData constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function normalizeUserAttributeMap()
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
                return $this->client->apiBaseUrl . ArrayHelper::getValue($attributes, 'id') . '/picture?type=large';
            },
        ];
    }
}