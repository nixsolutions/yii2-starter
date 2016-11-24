<?php

namespace app\modules\user\controllers;

use app\modules\user\models\AuthAssignment;
use app\modules\user\models\AuthItem;
use app\modules\user\models\User;
use Yii;
use app\modules\user\models\SearchUser;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRU actions for Users model.
 */
class UserController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update'],
                        'roles' => ['?', User::ROLE_ADMIN],
                    ],
                ]
            ]
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new User();
        $authAssignmentModel = new AuthAssignment;
        $roles = ArrayHelper::map(AuthItem::find()->all(), 'name', 'name');

        if (!$user->load(Yii::$app->request->post()) || !$user->validate()) {
            return $this->render('create', compact('user', 'authAssignmentModel', 'roles'));
        }

        $transaction = $user->getDb()->beginTransaction();
        if (!$user->save(false)) {
            $transaction->rollBack();
            return $this->render('create', compact('user', 'authAssignmentModel', 'roles'));
        }

        $authAssignmentModel->load(Yii::$app->request->post());
        $authAssignmentModel->link('user', $user);
        $transaction->commit();

        Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User created'));
        return $this->redirect(['view', 'id' => $user->id]);
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
        $authAssignmentModel = AuthAssignment::findOne(['user_id' => $id]) ?: new AuthAssignment();
        $roles = ArrayHelper::map(AuthItem::find()->all(), 'name', 'name');

        $postData = Yii::$app->request->post();
        if (!$user->load($postData) || !$authAssignmentModel->load($postData)) {
            return $this->render('create', compact('user', 'authAssignmentModel', 'roles'));
        }

        if (!$user->validate()) {
            return $this->render('create', compact('user', 'authAssignmentModel', 'roles'));
        }
        $transaction = $user->getDb()->beginTransaction();
        $user->save(false);

        if ($authAssignmentModel->isNewRecord) {
            $authAssignmentModel->user_id = $user->getId();
        }
        if (!$authAssignmentModel->validate()) {
            $transaction->rollBack();
            return $this->render('create', compact('user', 'authAssignmentModel', 'roles'));
        }
        $authAssignmentModel->save(false);
        $transaction->commit();

        Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Information saved'));
        return $this->redirect(['view', 'id' => $user->id]);
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
