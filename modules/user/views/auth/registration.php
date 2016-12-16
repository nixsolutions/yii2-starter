<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->registerCssFile('@web/css/modules/user/registration.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('user', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title); ?></h1>

    <p>Please fill out the following fields for registration:</p>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'lastName')->textInput(); ?>

    <?= $form->field($model, 'email')->textInput(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput(); ?>

    <?php echo $form->field($model, 'avatar')
        ->widget(budyaga\cropper\Widget::className(), [
        'uploadUrl' => Url::toRoute('/user/auth/uploadPhoto'),
        'cropAreaWidth' => 870,
        'cropAreaHeight' => 500,
        'width' => 500,
        'height' => 500,
    ]) ?>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton(Yii::t('user', 'Register'),
                ['class' => 'btn btn-primary', 'name' => 'register-button']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
