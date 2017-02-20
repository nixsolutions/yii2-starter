<?php

use app\assets\AppAsset;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $userForm \app\modules\user\models\forms\UserForm */

$this->registerJsFile('@web/js/modules/user/update.js', ['depends' => [AppAsset::className()]]);
$this->registerCssFile('@web/css/modules/user/update.css', ['depends' => [BootstrapAsset::className()]]);
$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Users',
]) . $userForm->first_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Profile'), 'url' => [Url::to('profile')]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="users-update">

    <h1><?= Html::encode($this->title); ?></h1>

    <?= $this->render('_form', [
        'user' => $userForm,
    ]); ?>

</div>
