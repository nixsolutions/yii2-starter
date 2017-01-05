<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class TwitterData
 * @package app\modules\user\social
 */
class TwitterData
{
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
            'avatar' => 'profile_image_url',
        ];
    }
}