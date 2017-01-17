<?php

use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorWidgetAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\mailTemplate\models\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/justify/plugin.js', ['depends' => [CKEditorWidgetAsset::className()]]);
?>

<div class="mail-template-form">

    <?php $form = ActiveForm::begin(['id' => 'mailTemplateForm']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

    <h4><?= Yii::t('mailTemplate', 'Example placeholders {{user}} {{date}} {{link}} {{password}}'); ?></h4>
    <?= $form->field($model, 'body')->widget(CKEditor::className(), [
        'options' => ['rows' => 8],
        'preset' => 'full',
        'clientOptions' => [
            'allowedContent' => true,
            'extraPlugins' => 'justify',
            'height' => 400,
            'toolbarGroups' => [
                ['name' => 'alignment', 'groups' => [ 'list', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ]],
            ],
            'resize_enabled' => true,
        ],

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('mailTemplate', 'Create') : Yii::t('mailTemplate', 'Update'),
            ['name' => 'mail-template-button', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']
        ); ?>
        <?= Html::a(Yii::t('mailTemplate', 'Cancel'), ['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
