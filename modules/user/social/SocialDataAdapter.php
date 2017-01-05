<?php

namespace app\modules\user\social;
use yii\base\Exception;

/**
 * Class SocialDataAdapter
 * @package app\modules\user\social
 */
class SocialDataAdapter
{
    /**
     * Chooses adapter for data from social account.
     * @param $client
     * @return mixed
     * @throws Exception
     */
    public static function getAdapter($client)
    {
        $className = __NAMESPACE__ . '\\' . ucfirst($client->getName()) . 'Data';
        if (!class_exists($className)) {
            throw new Exception('Class does not exist.');
        }

        $client->setNormalizeUserAttributeMap((new $className($client))->normalizeUserAttributeMap());
        $client->setUserAttributes($client->getUserAttributes());

        return $client->getUserAttributes();
    }
}