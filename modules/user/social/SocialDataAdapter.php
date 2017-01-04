<?php

namespace app\modules\user\social;

/**
 * Class SocialDataAdapter
 * @package app\modules\user\social
 */
class SocialDataAdapter
{
    /**
     * Chooses adapter for data from social account.
     *
     * @param $client
     * @return mixed
     */
    public static function getAdapter($client)
    {
        $className = __NAMESPACE__ . '\\' . ucfirst($client->getName()) . 'Data';
        return new $className($client->getUserAttributes());
    }
}