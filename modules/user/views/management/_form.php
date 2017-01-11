<?php

use app\modules\user\models\User;
use app\widgets\crop\Crop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */
/* @var $roles array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <div class="form-group">
        <?= Html::activeLabel($user, 'avatar') ?>
        <?= Crop::widget([
            'uploadUrl' => '/user/auth/upload-avatar',
            'inputLabel' => 'Choose',
            'modalLabel' => 'Set avatar',
            'noPhotoUrl' => $user->avatar ?: User::DEFAULT_AVATAR_URL,
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::button(
            Yii::t('app', 'Delete'),
            ['class' => 'btn btn-danger btn-block button-width', 'id' => 'deleteAvatar']
        ); ?>
    </div>

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

    <?= Html::activeHiddenInput($user, 'avatar', ['id' => 'avatar-field']); ?>
    <?php ActiveForm::end(); ?>

</div>
