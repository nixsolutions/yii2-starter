<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class GoogleData
 * @package app\modules\user\social
 */
class GoogleData extends SocialData
{
    /**
     * Gets user's avatar
     * @return string
     */
    public function getAvatar()
    {
        return current(explode('?',  ArrayHelper::getValue($this->userAttributes, 'image.url')));
    }

    /**
     * Gets user's first name
     * @return mixed
     */
    public function getFirstName()
    {
        return ArrayHelper::getValue($this->userAttributes, 'name.givenName');
    }

    /**
     * Gets user's last name
     * @return mixed
     */
    public function getLastName()
    {
        return ArrayHelper::getValue($this->userAttributes, 'name.familyName');
    }

    /**
     * Gets user's email
     * @return mixed
     */
    public function getEmail()
    {
        return ArrayHelper::getValue($this->userAttributes, 'emails.0.value');
    }
}