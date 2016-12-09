<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = Yii::t('page', $model->title);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-page">

    <h1><?= Yii::t('page', $model->title); ?></h1>

    <div class="body-content">
        <?= Yii::t('page', $model->content); ?>
    </div>

</div>