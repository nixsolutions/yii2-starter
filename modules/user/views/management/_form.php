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

    <?php $form = ActiveForm::begin(['id' => 'userForm']); ?>

    <?= $form->field($user, 'firstName')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'lastName')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'email')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'status')->dropDownList(
        [
            'created' => Yii::t('user', 'Created'),
            'active' => Yii::t('user', 'Active'),
            'blocked' => Yii::t('user', 'Blocked'),
        ]
    ); ?>

    <?= $form->field($user, 'role')->dropDownList($roles); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
