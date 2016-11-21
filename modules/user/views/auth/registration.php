<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('confirmRegistration')): ?>

        <div class="alert alert-success">
            Please, check your email to confirm registration.
        </div>

    <?php else: ?>

        <p>Please fill out the following fields for registration:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'registration-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'lastName')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), ['captchaAction' => 'auth/captcha',
        'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>


        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    <?php endif; ?>
</div>
