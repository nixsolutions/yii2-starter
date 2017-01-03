<?php
/**
 * Created by PhpStorm.
 * User: zmievskaya
 * Date: 03.01.17
 * Time: 12:26
 */

namespace app\modules\user;


use yii\helpers\ArrayHelper;

class SocialDataAdapter
{
    /**
     * @var array
     */
    public $socialData = [];

    /**
     * @param $userAttributes
     * @param $client
     * @return array
     */
    public function facebook($userAttributes, $client)
    {
        $this->socialData['firstName'] = explode(' ', ArrayHelper::getValue($userAttributes, 'name'))[0];
        $this->socialData['lastName'] = explode(' ', ArrayHelper::getValue($userAttributes, 'name'))[1];
        $this->socialData['email'] = ArrayHelper::getValue($userAttributes, 'email');
        $this->socialData['socialId'] = ArrayHelper::getValue($userAttributes, 'id');
        $this->socialData['avatar'] = $client->apiBaseUrl . ArrayHelper::getValue($userAttributes, 'id') . '/picture?type=large';

        return $this->socialData;
    }

    /**
     * @param $userAttributes
     * @return array
     */
    public function twitter($userAttributes)
    {
        $this->socialData['firstName'] = explode(' ', ArrayHelper::getValue($userAttributes, 'name'))[0];
        $this->socialData['lastName'] = explode(' ', ArrayHelper::getValue($userAttributes, 'name'))[1];
        $this->socialData['email'] = ArrayHelper::getValue($userAttributes, 'email');
        $this->socialData['socialId'] = ArrayHelper::getValue($userAttributes, 'id');
        $this->socialData['avatar'] = ArrayHelper::getValue($userAttributes, 'profile_image_url');

        return $this->socialData;
    }

    /**
     * @param $userAttributes
     * @return array
     */
    public function google($userAttributes)
    {
        $this->socialData['firstName'] = ArrayHelper::getValue($userAttributes, 'name.givenName');
        $this->socialData['lastName'] = ArrayHelper::getValue($userAttributes, 'name.familyName');
        $this->socialData['email'] = ArrayHelper::getValue($userAttributes, 'emails.0.value');
        $this->socialData['socialId'] = ArrayHelper::getValue($userAttributes, 'id');
        $this->socialData['avatar'] = current(explode('?',  ArrayHelper::getValue($userAttributes, 'image.url')));

        return $this->socialData;
    }
}