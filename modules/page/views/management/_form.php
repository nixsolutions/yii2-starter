<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
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

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('page', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']); ?>
        <?= Html::a(Yii::t('page', 'Cancel'), ['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
