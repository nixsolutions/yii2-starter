<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class FacebookData
 * @package app\modules\user\social
 */
class FacebookData extends SocialData
{
    /**
     * Gets user's avatar.
     * @param $client
     * @return string
     */
    public function getAvatar($client)
    {
        return $client->apiBaseUrl . ArrayHelper::getValue($this->userAttributes, 'id') . '/picture?type=large';
    }
}