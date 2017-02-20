<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->registerCssFile('@web/css/modules/user/login.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title); ?></h1>

    <p><?= Yii::t('user', 'Please fill out the following fields to login:'); ?></p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->textInput(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-12\">{input} {label}</div>\n<div class=\"col-lg-12\">{error}</div>",
    ]); ?>

    <div class="form-group">
        <div class="col-lg-12">
            <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => [Url::to('auth')]]); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::a('Forgot password?', [Url::to('/recovery')]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div>
        <?= Html::a(Yii::t('user', 'Click here to create an account.'), [Url::to('/registration')]); ?>
    </div>
</div>
