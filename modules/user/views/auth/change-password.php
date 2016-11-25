<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/user-module.css', ['depends' => [BootstrapAsset::className()]]);
$this->title = 'Password changing';
?>
<div class="site-recovery">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to change your password:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'change-password-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'repeatPassword')->passwordInput(); ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-11">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
