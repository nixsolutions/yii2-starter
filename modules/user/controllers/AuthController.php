<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\user\models\forms\RegistrationForm;

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
     */
    public function actionRegistration()
    {
        $registrationForm = new RegistrationForm();

        if ($registrationForm->load(Yii::$app->request->post()) && $registrationForm->validate()) {
            $user = new User();
            $user->register($registrationForm);
            Yii::$app->session->setFlash('confirmRegistration');
            return $this->refresh();
        }
        return $this->render('registration', [
            'model' => $registrationForm,
        ]);
    }
}
