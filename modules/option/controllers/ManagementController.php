<?php

namespace app\modules\option\controllers;

use app\modules\user\models\User;
use Yii;
use app\modules\option\models\Option;
use app\modules\option\models\OptionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ManagementController implements the CRUD actions for Option model.
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
     * Lists all Option models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Option model.
     *
     * @param string $namespace
     * @param string $key
     * @return mixed
     */
    public function actionView($namespace, $key)
    {
        return $this->render('view', [
            'model' => $this->findModel($namespace, $key),
        ]);
    }

    /**
     * Updates an existing Option model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $namespace
     * @param string $key
     * @return mixed
     */
    public function actionUpdate($namespace, $key)
    {
        $model = $this->findModel($namespace, $key);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'namespace' => $model->namespace, 'key' => $model->key]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Option model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $namespace
     * @param string $key
     * @return Option the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($namespace, $key)
    {
        $model = Option::findOne(['namespace' => $namespace, 'key' => $key]);
        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;

    }
}
