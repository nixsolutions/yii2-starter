<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$dataProvider->pagination->pageSize = Yii::$app->params['grid']['itemsPrePage'];
?>
<div class="users-index">

    <h1><?= Html::encode($this->title); ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => yii\grid\SerialColumn::className()],
            [
                'label' => Yii::t('user', 'Avatar'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img($model->avatar, [
                        'alt' => Yii::t('user', 'Avatar'),
                        'style' => 'width:120px;',
                    ]);
                },
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
                'content' => function ($model) {
                    $color = User::STATUS_ACTIVE === $model->status ? 'green' : 'grey';
                    $color = User::STATUS_BLOCKED === $model->status ? 'red' : $color;
                    return "<p style='color: {$color}'>$model->status</p>";
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    [
                        User::STATUS_ACTIVE => ucfirst(User::STATUS_ACTIVE),
                        User::STATUS_CREATED => ucfirst(User::STATUS_CREATED),
                        User::STATUS_BLOCKED => ucfirst(User::STATUS_BLOCKED),
                    ],
                    ['prompt' => Yii::t('user', 'All'), 'class' => 'form-control']
                ),
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'last_login_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'class' => yii\grid\DataColumn::className(),
                'label' => \Yii::t('user', 'Role'),
                'attribute' => 'authAssignments.item_name',
                'value' => function ($model) {
                    return $model->getRoleName() ?: 'no role';
                },
            ],
            [
                'class' => yii\grid\ActionColumn::className(),
                'header' => Yii::t('user', 'Actions'),
                'headerOptions' => ['width' => '35'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
</div>