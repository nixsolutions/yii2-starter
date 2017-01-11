<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */
/* @var $roles array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['id' => 'userForm']); ?>

    <?= $form->field($user, 'first_name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'last_name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'status')->dropDownList(
        [
            'created' => Yii::t('user', 'Created'),
            'active' => Yii::t('user', 'Active'),
            'blocked' => Yii::t('user', 'Blocked'),
        ]
    ); ?>

    <?= $form->field($user, 'role')->dropDownList([
        User::ROLE_USER => ucfirst(User::ROLE_USER),
        User::ROLE_ADMIN => ucfirst(User::ROLE_ADMIN),
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']); ?>
        <?= Html::a(Yii::t('user', 'Cancel'), ['index'], ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
