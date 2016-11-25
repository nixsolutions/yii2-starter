<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/user-module.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = 'Registration';
?>
<div class="site-register">
    <h1><?= Html::encode($this->title); ?></h1>

    <p>Please fill out the following fields for registration:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'lastName')->textInput(); ?>

    <?= $form->field($model, 'email')->textInput(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput(); ?>


    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-11">
            <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
