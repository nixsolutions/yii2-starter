<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\mailTemplate\models\MailTemplate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mail Templates'), 'url' => [Url::to('index')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mail-template-view">

    <h1><?= Html::encode($this->title); ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'subject',
            'key',
            'updated_at:datetime',
            [
                'label' => Yii::t('mailTemplate', 'Body'),
                'attribute' => 'body',
                'format' => 'raw',
                'value' => $model->body,
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?= Html::a(Yii::t('mailTemplate', 'Cancel'), [Url::to('index')], ['class' => 'btn btn-default']); ?>
    </p>
    
</div>
