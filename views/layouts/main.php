<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\user\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [];
    $user = Yii::$app->user;
    if ($user->can(User::ROLE_ADMIN)) {
        $menuItems[] = [
            'label' => 'Manage',
            'items' => [
                ['label' => 'Mail Templates', 'url' => ['/mail-template']],
                ['label' => 'Users', 'url' => ['/users']],
            ],
        ];
    }
    if ($user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/login']];
    } else {
        $menuItems[] = ['label' => 'Profile', 'url' => ['/user/default/profile']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . $user->identity->first_name . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';

    }
    ?>
    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]); ?>
    <?php NavBar::end(); ?>

    <div class="container">
        <?php
        foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
            <div class="flash alert alert-<?= $key; ?>">
                <strong><?= ucfirst($key) ?>!</strong> <?= $message ?>
            </div>
        <?php endforeach; ?>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
