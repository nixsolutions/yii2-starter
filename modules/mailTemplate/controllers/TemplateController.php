<?php

namespace app\modules\mailTemplate\controllers;

use app\modules\mailTemplate\models\Mail;
use Yii;
use app\modules\mailTemplate\models\MailTemplate;
use app\modules\mailTemplate\models\SearchMailTemplate;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemplateController implements the CRUD actions for MailTemplate model.
 */
class TemplateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update',],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view' ,'test'],
                        'roles' => ['?', '@']
                    ],
                ]
            ]
        ];
    }

    public function actionTest()
    {
        if (!$mailTemplate = MailTemplate::findByKey('REGISTER')) {
            throw new \Exception('Template not found in database');
        }

        $mailTemplate->replacePlaceholders([
            'user' => 'vasia',
            'data' => '21.03.2018',
            'link' => 'https://www.google.com.ua',
            'password' => 'qwerty',
            'password2' => '123456',
            'password3' => '123456',
        ]);

        $sendMail = new Mail();
        $sendMail->setTemplate($mailTemplate);
        $sendMail->sendTo('goodeveningproj@gmail.com');
    }

    /**
     * Lists all MailTemplate models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMailTemplate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MailTemplate model.
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
     * Updates an existing MailTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the MailTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return MailTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = MailTemplate::findOne($id);
        if (null === $model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
