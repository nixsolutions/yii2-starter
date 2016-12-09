<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'key',
            'title',
            'content',
            'description',
            'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('page', 'Actions'),
                'headerOptions' => ['width' => '35'],
                'contentOptions' => ['style' => 'text-align: center'],
                'template' => '{view}  {update}',
            ],
        ],
    ]); ?>
</div>
