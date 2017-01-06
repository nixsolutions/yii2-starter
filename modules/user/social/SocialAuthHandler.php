<?php

namespace app\modules\user\social;

use app\modules\user\models\User;
use BadMethodCallException;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * Class SocialAuthHandler
 *
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

    /**
     * SocialAuthHandler constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Handles authorization through social networks.
     *
     * @throws BadMethodCallException
     */
    public function auth()
    {
        $userAttributes = $this->client->getUserAttributes();
        $this->user = $this->getUser($userAttributes);
        if (User::STATUS_BLOCKED === $this->user->status) {
            Yii::$app->session->setFlash('danger', Yii::t('user', 'Your account is blocked.'));
        }

        $userAttributes['authProvider'] = $this->client->getName();
        if (!$this->user->saveSocialAccountInfo($userAttributes)) {
            throw new BadMethodCallException('Social data could not be saved.');
        }
        $this->user->login();
    }

    /**
     * Find user if exist or create new
     *
     * @param $userAttributes
     * @return User
     */
    protected function getUser($userAttributes)
    {
        return User::findByEmail(ArrayHelper::getValue($userAttributes, 'email')) ?: new User();

    }
}
