<?php

use app\modules\user\models\User;
use dosamigos\datepicker\DatePicker;
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
            ['class' => yii\grid\SerialColumn::className()],
            [
                'label' => Yii::t('user', 'Avatar'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img($model->avatar, [
                        'alt' => Yii::t('user', 'Avatar'),
                        'style' => 'width:60px;',
                        'class' => 'img-circle',
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
                    $label = User::STATUS_ACTIVE === $model->status ? 'success' : 'default';
                    $label = User::STATUS_BLOCKED === $model->status ? 'danger' : $label;
                    return "<span class='visible-md-block visible-xs-block
                        visible-sm-block visible-lg-block label label-{$label}'>{$model->status}</span>";
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
                'value' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'clientOptions' => ['format' => 'yyyy-mm-d']
                ]),
                'format' => 'html',
                'content' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
            ],
            [
                'attribute' => 'last_login_at',
                'value' => 'last_login_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'last_login_at',
                    'clientOptions' => ['format' => 'yyyy-mm-d']
                ]),
                'format' => 'html',
                'content' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->last_login_at);
                },
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