<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use app\assets\AppAsset;
use app\widgets\crop\Crop;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('@web/js/modules/user/registration.js', ['depends' => [AppAsset::className()]]);
$this->registerCssFile('@web/css/modules/user/registration.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('user', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title); ?></h1>

    <?= Crop::widget([
        'uploadUrl' => '/user/auth/upload-avatar',
        'inputLabel' => 'Choose',
        'modalLabel' => 'Set avatar',
    ]) ?>


    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'firstName')->textInput(); ?>

    <?= $form->field($model, 'lastName')->textInput(); ?>

    <?= $form->field($model, 'email')->textInput(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput(); ?>

    <?= Html::activeHiddenInput($model, 'avatar', ['id' => 'avatar-field']); ?>

    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton(
                Yii::t('user', 'Register'),
                ['class' => 'btn btn-primary', 'name' => 'register-button']
            ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


