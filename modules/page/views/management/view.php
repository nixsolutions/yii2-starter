<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('page', 'Static Pages'), 'url' => [Url::to('index')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h1><?= Html::encode($this->title); ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'key',
            'title',
            [
                'label' => Yii::t('page', 'Content'),
                'attribute' => 'content',
                'format' => 'raw',
                'value' => $model->content,
            ],
            'description',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <p>
        <?= Html::a(Yii::t('page', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a(Yii::t('page', 'Cancel'), [Url::to('index')], ['class' => 'btn btn-default']); ?>
    </p>

</div>
