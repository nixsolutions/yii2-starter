<?php

use app\modules\feedback\models\Feedback;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\feedback\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('feedback', 'Feedbacks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'email:email',
            'message:ntext',
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
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('feedback', 'Actions'),
                'headerOptions' => ['width' => '35'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
</div>
