<?php

use app\modules\user\models\User;
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
                'filter' => [
                    User::STATUS_ACTIVE => ucfirst(User::STATUS_ACTIVE),
                    User::STATUS_CREATED => ucfirst(User::STATUS_CREATED),
                    User::STATUS_BLOCKED => ucfirst(User::STATUS_BLOCKED),
                ],
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
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    },
                    'update' => function ($url, $model) {
                        return User::ROLE_ADMIN === $model->getRoleName() ? ''
                            : Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                ],
            ],
        ],
    ]); ?>
</div>