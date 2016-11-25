<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/user-module.css', ['depends' => [BootstrapAsset::className()]]);
$this->title = 'Password recovery';
?>
<div class="site-recovery">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter your email to reset password:</p>

    <?= Html::beginForm('recovery', 'post', ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <?= Html::label('Email', 'email', ['class' => 'col-lg-2 control-label']); ?>
    <div class="col-lg-3">
        <?= Html::input('email', 'email', null, ['label' => 'Email', 'class' => 'form-control']); ?>
    </div>
    <?= Html::endForm(); ?>

</div>
