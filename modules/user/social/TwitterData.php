<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class TwitterData
 * @package app\modules\user\social
 */
class TwitterData extends SocialData
{
    /**
     * Gets user's avatar.
     * @return string
     */
    public function getAvatar()
    {
        return ArrayHelper::getValue($this->userAttributes, 'profile_image_url');
    }
}