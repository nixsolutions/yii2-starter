<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\SearchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id'); ?>

    <?= $form->field($model, 'first_name'); ?>

    <?= $form->field($model, 'last_name'); ?>

    <?= $form->field($model, 'email'); ?>

    <?= $form->field($model, 'password'); ?>

    <?= $form->field($model, 'status'); ?>

    <?= $form->field($model, 'created_at'); ?>

    <?= $form->field($model, 'last_login_at'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
