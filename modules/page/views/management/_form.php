<?php

use app\assets\WysiwygAsset;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */
WysiwygAsset::register($this);
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(['id' => 'pageForm']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 8],
        'preset' => 'full',
        'clientOptions' => [
            'allowedContent' => true,
            'extraPlugins' => 'justify',
            'height' => 400,
            'toolbarGroups' => [
                ['name' => 'alignment', 'groups' => ['list', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']],
            ],
            'resize_enabled' => true,
        ],

    ]); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('page', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']); ?>
        <?= Html::a(Yii::t('page', 'Cancel'), [Url::to('index')], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
