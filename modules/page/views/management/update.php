<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */

$this->title = Yii::t('page', 'Update {modelClass}: ', [
    'modelClass' => 'Static Page',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('page', 'Static Pages'), 'url' => [Url::to('index')]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('page', 'Update');
?>
<div class="page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
