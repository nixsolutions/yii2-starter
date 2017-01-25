<?php

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = $model->first_name;
$this->params['breadcrumbs'][] = $model->first_name;
$this->registerCssFile('@web/css/modules/user/profile.css');
?>
<div class="users-view">

    <h1><?= Html::encode($model->first_name); ?></h1>


    <div class="form-group">
        <?= Html::img(
            $model->avatar ? : User::DEFAULT_AVATAR_URL,
            ['alt' => 'User avatar', 'width' => 200, 'height' => 200, 'class' => 'avatar-border']
        ) ?>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'first_name',
            'last_name',
            'email:email',
            [
                'label' => Yii::t('user', 'Role'),
                'value' => $model->getRoleName(),
            ],
            'status',
            'created_at',
            'last_login_at',
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::a(Yii::t('user', 'Change password'), [Url::to('send-change-password-mail')], ['class' => 'btn btn-primary']); ?>
        <?= Html::a(Yii::t('user', 'Update'), [Url::to('update'), 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
    </div>

</div>
