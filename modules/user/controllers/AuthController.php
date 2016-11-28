<?php

namespace app\modules\user\controllers;

use app\modules\mailTemplate\models\Mail;
use app\modules\mailTemplate\models\MailTemplate;
use app\modules\user\models\Hash;
use app\modules\user\models\User;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\modules\user\models\forms\RegistrationForm;
use yii\web\NotFoundHttpException;

/**
 * AuthController for the `user` module
 */
class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['registration'],
                'rules' => [
                    [
                        'actions' => ['registration'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionRegistration()
    {
        $registrationForm = new RegistrationForm();

        if ($registrationForm->load(Yii::$app->request->post()) && $registrationForm->validate()) {
            $user = new User();

            if (!$user = $user->create($registrationForm)) {
                throw new Exception('Data could not be saved into database.');
            }

            if (!$mailTemplate = MailTemplate::findByKey('REGISTER')) {
                throw new NotFoundHttpException('Template is not found in database.');
            }
            $hash = new Hash();
            $mailTemplate->replacePlaceholders([
                'name' => $user->first_name,
                'link' => Yii::$app->urlManager->createAbsoluteUrl(['user/auth/confirm-registration',
                    'hash' => $hash->generate(Hash::TYPE_REGISTER, $user->id)
                ]),
            ]);

            $mail = new Mail();
            $mail->setTemplate($mailTemplate);
            if (!$mail->sendTo($user->email)) {
                throw new Exception('Email couldn\'t be sent. Check your email account please.');
            }
            Yii::$app->session->setFlash('success',
                Yii::t('user', 'Please, check your email to confirm registration.'));
        }

        return $this->render('registration', [
            'model' => $registrationForm,
        ]);
    }

    /**
     * @return bool|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionConfirmRegistration()
    {
        if (!$hash = Yii::$app->request->get('hash')) {
            throw new BadRequestHttpException();
        }

        if (!Hash::find()->where(['hash' => $hash])) {
            throw new Exception('Hash is not found in database.');
        }
        $user = User::findByHash($hash);
        $user->status = User::STATUS_ACTIVE;
        $user->update();
        if (!$user->login()) {
            throw new Exception('Invalid user data.');
        }
        return $this->goHome();
    }
}
