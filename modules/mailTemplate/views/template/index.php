<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\mailTemplate\models\SearchMailTemplate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mail Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-template-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['width' => '10'],
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'key',
                'headerOptions' => ['width' => '130'],
            ],
            [
                'attribute' => 'subject',
                'headerOptions' => ['width' => '300'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('mailTemplate', 'Actions'),
                'headerOptions' => ['width' => '65'],
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
