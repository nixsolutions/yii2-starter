<?php

namespace app\modules\user\controllers;

use app\modules\mailTemplate\models\Mail;
use app\modules\mailTemplate\models\MailTemplate;
use app\modules\user\models\Hash;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\user\models\forms\RegistrationForm;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `user` module
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
     * @throws NotFoundHttpException
     */
    public function actionRegistration()
    {
        $registrationForm = new RegistrationForm();

        if ($registrationForm->load(Yii::$app->request->post()) && $registrationForm->validate()) {
            $user = new User();

            if ($hashData = $user->register($registrationForm)) {

                if (!$mailTemplate = MailTemplate::findByKey('REGISTER')) {
                    throw new NotFoundHttpException('Template not found in database');
                }
                $mailTemplate->replacePlaceholders([
                    'name' => $user->first_name,
                    'link' => Yii::$app->urlManager->createAbsoluteUrl(['user/auth/confirm',
                        'user_id' => $hashData['user_id'],
                        'hash' => $hashData['hash']
                    ]),
                ]);

                $mail = new Mail();
                $mail->setTemplate($mailTemplate);
                $mail->sendTo($user->email);

                Yii::$app->session->setFlash('confirmRegistration');
                return $this->refresh();
            }
        }
        return $this->render('registration', [
            'model' => $registrationForm,
        ]);
    }

    /**
     * @return bool
     */
    public function actionConfirm()
    {
        if (($user_id = Yii::$app->request->get('user_id')) && ($hash = Yii::$app->request->get('hash'))) {
            if (Hash::find()->where(['user_id' => $user_id, 'hash' => $hash])) {
                $user = User::findIdentity($user_id);
                $user->status = 'active';
                $user->update();
            }
        }
        return false;
    }
}
