<?php

use app\modules\feedback\models\Feedback;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\feedback\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCssFile('@web/css/modules/feedback/index.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('feedback', 'Feedbacks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => yii\grid\SerialColumn::class],
            'name',
            'email:email',
            [
                'attribute' => 'message',
                'value' => function ($model) {
                    return StringHelper::truncate($model->message, 150);
                },
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '130'],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    [
                        Feedback::STATUS_NEW => ucfirst(Feedback::STATUS_NEW),
                        Feedback::STATUS_ANSWERED => ucfirst(Feedback::STATUS_ANSWERED),
                    ],
                    ['prompt' => Yii::t('feedback', 'All'), 'class' => 'form-control']
                ),
                'content' => function ($model) {
                    $label = Feedback::STATUS_ANSWERED === $model->status ? 'success' : 'danger';
                    return "<span class='visible-md-block visible-xs-block
                        visible-sm-block visible-lg-block label label-{$label}'>{$model->status}</span>";
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'clientOptions' => ['format' => 'yyyy-mm-d']
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'clientOptions' => ['format' => 'yyyy-mm-d']
                ]),
                'format' => 'html',
                'content' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
            [
                'class' => yii\grid\ActionColumn::class,
                'header' => Yii::t('feedback', 'Actions'),
                'headerOptions' => ['width' => '75'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view} {answered} ',
                'buttons' => [
                    'answered' => function ($url, $model) {
                        return Feedback::STATUS_NEW === $model->status ?
                            Html::beginForm(
                                ['/feedback/management/update?id=' . $model->id],
                                'post',
                                ['class' => 'form-button-inline']
                            )
                            . Html::activeHiddenInput($model, 'status', ['value' => Feedback::STATUS_ANSWERED])
                            . Html::a(
                                '<span class="glyphicon glyphicon-comment"></span>',
                                '#',
                                [
                                    'title' => Yii::t('feedback', 'Mark as answered'),
                                    'data' => ['method' => 'post'],
                                ]
                            )
                            . Html::endForm() :
                            Html::a(
                                '<span class="glyphicon glyphicon-comment text-muted"></span>',
                                '#',
                                ['title' => Yii::t('feedback', 'Answered')]
                            );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
