<?php

namespace app\modules\user\controllers;

use app\modules\user\models\forms\UserForm;
use app\modules\user\models\User;
use Yii;
use app\modules\user\models\SearchUser;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ManagementController implements the CRU actions for Users model.
 */
class ManagementController extends Controller
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
                        'actions' => ['index', 'view', 'update'],
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $userForm = new UserForm();
        $userForm->setAttributes($user->attributes);
        $userForm->role = $user->getRoleName();

        if ($userForm->load(Yii::$app->request->post())
            && $userForm->validate()
            && User::ROLE_ADMIN !== $user->getRoleName()
        ) {
            $user->setAttributes($userForm->attributes);
            $user->update(false);
            $user->setRole($userForm->role);

            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Information saved.'));
            return $this->redirect(['view', 'id' => $user->id]);
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
