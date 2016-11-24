<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */
/* @var $authAssignmentModel app\modules\user\models\AuthAssignment */
/* @var $roles array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user, 'first_name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'last_name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'email')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'status')->dropDownList(
        [
            'created' => Yii::t('user', 'Created'),
            'active' => Yii::t('user', 'Active'),
            'blocked' => Yii::t('user', 'Blocked'),
        ]
    ); ?>

    <?= $form->field($user->authAssignments, 'item_name')->dropDownList($roles); ?>

    <div class="form-group">
        <?= Html::submitButton(
            $user->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
