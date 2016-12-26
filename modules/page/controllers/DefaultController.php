<?php

namespace app\modules\page\controllers;

use app\modules\page\models\Page;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `page` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the static pages view
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $page = trim(Yii::$app->request->url, '/');
        $key = substr($page, 0, strpos($page, '.html'));
        if (!$model = Page::findByKey($key)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('page', ['model' => $model]);
    }
}
