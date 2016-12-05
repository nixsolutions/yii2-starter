<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/modules/user/recovery.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('user', 'Password recovery');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-recovery">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please enter your email to reset password:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'recovery-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton(Yii::t('user', 'Send'), ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
