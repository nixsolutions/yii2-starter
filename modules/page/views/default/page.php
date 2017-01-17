<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = Yii::t('page', $model->title);
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', $model->description)
]);
?>
<div class="site-page">

    <h1><?= Yii::t('page', Yii::t('page', $model->title)); ?></h1>

    <div class="body-content">
        <?= Yii::t('page', Yii::t('page', $model->content)); ?>
    </div>

</div>