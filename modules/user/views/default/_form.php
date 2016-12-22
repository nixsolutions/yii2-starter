<?php

use app\widgets\crop\Crop;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */
/* @var $roles array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <div class="col-md-12">
        <?= Crop::widget([
            'uploadUrl' => '/user/crop/crop',
            'inputLabel' => 'Choose',
            'modalLabel' => 'Update avatar',
        ]) ?>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'userForm']); ?>

    <?= $form->field($user, 'first_name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($user, 'last_name')->textInput(['maxlength' => true]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
