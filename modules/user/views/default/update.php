<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userForm \app\modules\user\models\forms\UserForm */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Users',
]) . $userForm->first_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Profile'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-update">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= $this->render('_form', [
        'user' => $userForm,
    ]); ?>

</div>
