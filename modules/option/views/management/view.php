<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\option\models\Option */

$this->title = "$model->namespace $model->key";
$this->params['breadcrumbs'][] = ['label' => Yii::t('option', 'Options'), 'url' => [Url::to('index')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-view">

    <h1><?= Html::encode($this->title); ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'namespace',
            'key',
            'value',
            'description',
            'created_at',
            'updated_at',
        ],
    ]); ?>

    <p>
        <?= Html::a(Yii::t('option', 'Update'),
            ['update', 'namespace' => $model->namespace, 'key' => $model->key],
            ['class' => 'btn btn-primary']
        ); ?>
        <?= Html::a(Yii::t('option', 'Cancel'), [Url::to('index')], ['class' => 'btn btn-default']); ?>
    </p>
    
</div>
