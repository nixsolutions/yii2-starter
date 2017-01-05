<?php

namespace app\modules\user\social;


use yii\helpers\ArrayHelper;

/**
 * Class GoogleData
 * @package app\modules\user\social
 */
class GoogleData
{
    /**
     * @return array
     */
    public function getNormalizedUserAttributesMap()
    {
        return [
            'firstName' => ['name', 'givenName'],
            'lastName' => ['name', 'familyName'],
            'email' => ['emails', 0, 'value'],
            'socialId' => 'id',
            'avatar' => function ($attributes) {
                return current(explode('?',  ArrayHelper::getValue($attributes, 'image.url')));
            },
        ];
    }
}