<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $userForm \app\modules\user\models\forms\UpdateUserForm */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Users',
]) . $userForm->firstName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $userForm->firstName, 'url' => ['view', 'id' => $userForm->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-update">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= $this->render('_form', [
        'user' => $userForm,
        'roles' => $roles,
    ]); ?>

</div>
