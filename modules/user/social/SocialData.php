<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class SocialData
 * @package app\modules\user\social
 */
class SocialData
{
    protected $client;
    protected $userAttributes;

    /**
     * SocialData constructor.
     * @param $client
     * @param $userAttributes
     */
    public function __construct($client, $userAttributes)
    {
        $this->client = $client;
        $this->userAttributes = $userAttributes;
    }

    /**
     * Gets user's first name
     * @return mixed
     */
    public function getFirstName()
    {
        return explode(' ', ArrayHelper::getValue($this->userAttributes, 'name'))[0];
    }

    /**
     * Gets user's last name
     * @return mixed
     */
    public function getLastName()
    {
        return explode(' ', ArrayHelper::getValue($this->userAttributes, 'name'))[1];
    }

    /**
     * Gets user's email
     * @return mixed
     */
    public function getEmail()
    {
        return ArrayHelper::getValue($this->userAttributes, 'email');
    }

    /**
     * Gets user's social id
     * @return mixed
     */
    public function getSocialId()
    {
        return ArrayHelper::getValue($this->userAttributes, 'id');
    }
}