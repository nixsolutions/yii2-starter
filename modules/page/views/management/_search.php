<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id'); ?>

    <?= $form->field($model, 'key'); ?>

    <?= $form->field($model, 'title'); ?>

    <?= $form->field($model, 'content'); ?>

    <?= $form->field($model, 'description'); ?>

    <?= $form->field($model, 'created_at'); ?>

    <?= $form->field($model, 'updated_at'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('page', 'Search'), ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton(Yii::t('page', 'Reset'), ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
