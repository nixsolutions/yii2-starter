<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['profile'],
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
