<?php

namespace app\modules\user\controllers;

use app\modules\mailTemplate\models\Mail;
use app\modules\mailTemplate\models\MailTemplate;
use app\modules\user\models\forms\ChangePasswordForm;
use app\modules\user\models\forms\UserForm;
use app\modules\user\models\Hash;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Class DefaultController
 *
 * @package app\modules\user\controllers
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['profile', 'update', 'send-change-password-mail'],
                        'roles' => ['@'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Display user profile
     *
     * @return string
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => $this->findModel(Yii::$app->user->getId()),
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $userForm = new UserForm(['scenario' => UserForm::SCENARIO_PROFILE]);
        $userForm->setAttributes($user->attributes);

        if ($userForm->load(Yii::$app->request->post()) && $userForm->validate()) {
            $user->setAttributes($userForm->attributes);
            $user->update(false);
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Information saved.'));
            return $this->redirect(['profile']);
        }

        return $this->render('update', [
            'userForm' => $userForm,
            'id' => $user->id,
        ]);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = User::findOne($id);
        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionChangePassword()
    {
        if (!$hash = Yii::$app->request->get('hash')) {
            throw new BadRequestHttpException();
        }
        if (!$user = User::findByHash($hash)) {
            throw new ServerErrorHttpException('The server encountered an internal error and could not complete your request.');
        }
        $changePasswordForm = new ChangePasswordForm();

        if ($changePasswordForm->load(Yii::$app->request->post()) && $changePasswordForm->validate()) {
            $user->password = Yii::$app->security->generatePasswordHash($changePasswordForm->newPassword);
            $user->update();
            Hash::findByUserId($user->id)->delete();
            $user->login();

            return $this->goHome();
        }
        return $this->render('auth/change-password', [
            'model' => $changePasswordForm,
        ]);
    }

    /**
     * Sends link for changing password on user email
     *
     * @return string|\yii\web\Response
     * @throws ServerErrorHttpException
     */
    public function actionSendChangePasswordMail()
    {
        $user = $this->findModel(Yii::$app->user->getId());

        if (!$mailTemplate = MailTemplate::findByKey('CHANGE_PASSWORD')) {
            throw new ServerErrorHttpException('The server encountered an internal error and could not complete your request.');
        }

        $hash = new Hash();
        $mailTemplate->replacePlaceholders([
            'name' => $user->first_name,
            'link' => Yii::$app->urlManager->createAbsoluteUrl([
                Url::to('user/auth/change-password'),
                'hash' => $hash->generate(Hash::TYPE_RECOVER, $user->id),
            ]),
        ]);

        $mail = new Mail();
        $mail->setTemplate($mailTemplate);
        $mail->sendTo($user->email);

        Yii::$app->session->setFlash(
            'success',
            Yii::t('user', 'Please check your email and follow instructions to change your password.')
        );
        return $this->render('profile', [
            'model' => $user,
        ]);
    }
}
