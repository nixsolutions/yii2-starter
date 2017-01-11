<?php

use app\modules\feedback\models\Feedback;
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
                'headerOptions' => ['width' => '80'],
                'filter' => [
                    Feedback::STATUS_NEW => ucfirst(Feedback::STATUS_NEW),
                    Feedback::STATUS_ANSWERED => ucfirst(Feedback::STATUS_ANSWERED),
                ],
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => yii\grid\ActionColumn::class,
                'header' => Yii::t('feedback', 'Actions'),
                'headerOptions' => ['width' => '75'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view} {answered} ',
                'buttons' => [
                    'answered' => function ($url, $model) {
                        return Html::beginForm(
                                ['/feedback/management/update?id=' . $model->id],
                                'post',
                                ['class' => 'form-button-inline'])
                            . Html::activehiddenInput($model, 'status', ['value' => Feedback::STATUS_ANSWERED])
                            . Html::submitButton('<span class="glyphicon glyphicon-ok-sign">',
                                ['class' => 'btn-link']) . Html::endForm();
                    },
                ],
            ],
        ],
    ]); ?>
</div>
