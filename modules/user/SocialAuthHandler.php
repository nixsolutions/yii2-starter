<?php

namespace app\modules\user;

use app\modules\user\models\User;
use Exception;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

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

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function auth()
    {
        $clientName = $this->client->getName();

        if ($clientName == 'twitter') {
            $this->client->attributeParams = ['include_email' => 'true'];
        }
        $userAttributes = $this->client->getUserAttributes();
        $email = $clientName == 'google' ? ArrayHelper::getValue($userAttributes, 'emails.0.value') :
            ArrayHelper::getValue($userAttributes, 'email');

        if ((!$this->user = User::findBySocialId(ArrayHelper::getValue($userAttributes, 'id'))) && (!$this->user = User::findByEmail($email))) {
            $this->user = new User();
        }

        if (!$socialData = (new SocialDataAdapter())->$clientName($userAttributes, $this->client)) {
            throw new Exception('Social data could not be obtained.');
        }

        if (!$this->user->saveSocialAccountInfo($socialData, $clientName)) {
            throw new Exception('Social data could not be saved.');
        }

        $this->user->login();
    }
}