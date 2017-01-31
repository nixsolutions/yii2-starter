<?php

use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/modules/user/change-password.css', ['depends' => [BootstrapAsset::className()]]);

$form = ActiveForm::begin([
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