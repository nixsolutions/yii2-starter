<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title); ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '35'],
            ],
            [
                'attribute' => 'first_name',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute' => 'last_name',
                'headerOptions' => ['width' => '100'],
            ],
            'email:email',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '100'],
            ],
            'created_at:datetime',
            'last_login_at:datetime',
            [
                'class' => yii\grid\DataColumn::className(),
                'label' => \Yii::t('user', 'Role'),
                'attribute' => 'authAssignments.item_name',
                'value' => function ($model) {
                    return $model->getRoleName() ?: 'no role';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('user', 'Actions'),
                'headerOptions' => ['width' => '35'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
