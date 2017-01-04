<?php

namespace app\modules\user\social;

use app\modules\user\models\User;
use Exception;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * Class SocialAuthHandler
 * @package app\modules\user\social
 */
class SocialAuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var User
     */
    private $user;

    const TWITTER = 'twitter';
    const GOOGLE = 'google';

    /**
     * SocialAuthHandler constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Handles authorization through social networks
     * @throws Exception
     */
    public function auth()
    {
        $clientName = $this->client->getName();

        if ($clientName == self::TWITTER) {
            $this->client->attributeParams = ['include_email' => 'true'];
        }
        $userAttributes = $this->client->getUserAttributes();
        $email = $clientName == self::GOOGLE ? ArrayHelper::getValue($userAttributes, 'emails.0.value') :
            ArrayHelper::getValue($userAttributes, 'email');

        if ((!$this->user = User::findBySocialId(ArrayHelper::getValue($userAttributes, 'id'))) && (!$this->user = User::findByEmail($email))) {
            $this->user = new User();
        }

        if (!$adapter = SocialDataAdapter::getAdapter($this->client, $userAttributes)) {
            throw new Exception('Adapter does not exist.');
        }

        if (!$this->user->saveSocialAccountInfo($adapter, $clientName)) {
            throw new Exception('Social data could not be saved.');
        }

        $this->user->login();
    }
}