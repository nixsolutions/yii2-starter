<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\page\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('page', 'Static Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => yii\grid\SerialColumn::className()],
            'key',
            'title',
            [
                'attribute' => 'content',
                'value' => function ($model) {return StringHelper::truncate($model->content, 150);},
            ],
            'description',
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
                'headerOptions' => ['width' => '150'],
            ],
            [
                'class' => yii\grid\ActionColumn::className(),
                'header' => Yii::t('page', 'Actions'),
                'headerOptions' => ['width' => '35'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
</div>
