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

    /**
     * SocialAuthHandler constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Handles authorization through social networks.
     * @throws Exception
     */
    public function auth()
    {
        if (self::TWITTER === $this->client->getName()) {
            $this->client->attributeParams = ['include_email' => 'true'];
        }

        if (!$adapter = SocialDataAdapter::getAdapter($this->client)) {
            throw new Exception('Adapter does not exist.');
        }

        if ((!$this->user = User::findBySocialId(ArrayHelper::getValue($this->client->getUserAttributes(), 'id'))) &&
            (!$this->user = User::findByEmail($adapter->getEmail()))) {
            $this->user = new User();
        }

        if (!$this->user->saveSocialAccountInfo($adapter, $this->client)) {
            throw new Exception('Social data could not be saved.');
        }

        $this->user->login();
    }
}