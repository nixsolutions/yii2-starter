<?php

namespace app\modules\user\controllers;

use app\modules\user\models\forms\UserForm;
use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 *
 * @package app\modules\user\controllers
 */
class DefaultController extends \yii\web\Controller
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
                        'actions' => ['profile', 'update'],
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
     * If update is successful, the browser will be redirected to the 'view' page.
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
}
