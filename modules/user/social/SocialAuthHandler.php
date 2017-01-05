<?php

namespace app\modules\user\social;

use app\modules\user\models\User;
use Exception;
use Yii;
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

    const FACEBOOK = 'facebook';

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

        if (!$userAttributes = $this->getNormalizedAttributes()) {
            throw new Exception('Data not found.');
        }

        if ((!$this->user = User::findBySocialId(ArrayHelper::getValue($userAttributes, 'id'))) &&
            (!$this->user = User::findByEmail(ArrayHelper::getValue($userAttributes, 'email')))) {
            $this->user = new User();
        }

        if (User::STATUS_BLOCKED === $this->user->status) {
            Yii::$app->session->setFlash('danger', Yii::t('user', 'Your account is blocked.'));
        }

        if (!$this->user->saveSocialAccountInfo($this->client)) {
            throw new Exception('Social data could not be saved.');
        }

        $this->user->login();
    }

    /**
     * @return array|bool
     */
    public function getNormalizedAttributes()
    {
        $className = __NAMESPACE__ . '\\' . ucfirst($this->client->getName()) . 'Data';
        if (!class_exists($className)) {
            return false;
        }

        if (self::FACEBOOK === $this->client->getName()) {
            $className::setClient($this->client);
        }
        $this->client->setNormalizeUserAttributeMap($className::normalizeUserAttributeMap());
        $this->client->setUserAttributes($this->client->getUserAttributes());

        return $this->client->getUserAttributes();
    }
}