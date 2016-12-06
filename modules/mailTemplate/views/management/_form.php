<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mailTemplate\models\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-template-form">

    <?php $form = ActiveForm::begin(['id' => 'mailTemplateForm']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

    <h4><?= Yii::t('mailTemplate', 'Example placeholders {{user}} {{date}} {{link}} {{password}}'); ?></h4>
    <?= $form->field($model, 'body')->widget(CKEditor::className(), [
        'options' => ['rows' => 8],
        'preset' => 'basic',
        'clientOptions' => [
            'height' => 300,
            'toolbarGroups' => [
                ['name' => 'document', 'groups' => ['mode']],
                ['name' => 'basicstyles', 'groups' => ['cleanup']],
            ],
            'resize_enabled' => true,
        ],

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('mailTemplate', 'Create') : Yii::t('mailTemplate', 'Update'),
            ['name' => 'mail-template-button', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
