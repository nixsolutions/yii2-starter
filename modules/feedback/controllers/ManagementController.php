<?php

namespace app\modules\feedback\controllers;

use app\modules\feedback\models\forms\ContactForm;
use app\modules\user\models\User;
use Yii;
use app\modules\feedback\models\Feedback;
use app\modules\feedback\models\FeedbackSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ManagementController implements the CRUD actions for Feedback model.
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
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@', '?'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all Feedback models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feedback model.
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
     * Create new feedback message
     */
    public function actionCreate()
    {
        $model = new ContactForm();
        $model->email = isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $feedback = new Feedback();
            $feedback->setAttributes($model->attributes);
            $feedback->save(false);

            Yii::$app->session->setFlash(
                'success',
                'Thank you for contacting us. We will respond to you as soon as possible.'
            );

            return $this->refresh();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Feedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('feedback', 'Information saved.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Feedback::findOne($id);
        if (null !== $model) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}