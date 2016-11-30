<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@app/web/css/modules/user/change-password.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('user', 'Password changing');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-recovery">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to change your password:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'change-password-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'repeatPassword')->passwordInput(); ?>

    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
