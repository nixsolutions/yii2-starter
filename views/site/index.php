<?php

/* @var $this yii\web\View */

use app\modules\user\models\User;
use yii\helpers\Html;

$this->title = Yii::t('site', 'NIX Yii2 Application');
$user = Yii::$app->user;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('site', 'Welcome'); ?><?= !$user->isGuest ? ' ' . $user->identity->first_name : ''; ?>!</h1>

        <h2><?= Yii::t('site', 'NIX Solutions presents Demo Yii2 application.'); ?></h2>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">

                <div class="lead text-justify">
                    <p><?= Yii::t('site', 'Yii is a high-performance PHP framework best for developing Web 2.0
                     applications. Yii comes with rich features: MVC, DAO/ActiveRecord, I18N/L10N, caching, 
                     authentication and role-based access control, scaffolding, testing, etc. 
                     It can reduce your development time significantly.'); ?></p>

                    <p><?= Yii::t('site', 'We are glad to represent you demo of our Yii2 web application. It has:'); ?></p>
                    <ul>
                        <li><?= Yii::t('site', 'role-based access control, that gives possibility to limit users activity;');?></li>
                        <li><?= $user->isGuest ? Html::a(Yii::t('site', 'registration of new users with email confirmation'),
                                '/registration') : 'registration of new users with email confirmation'; ?>;</li>
                        <li><?= $user->isGuest ? Html::a(Yii::t('site', 'password recovery (with email)'),
                                '/recovery') : 'password recovery (with email)'; ?>;</li>
                        <li><?= $user->isGuest ? Html::a(Yii::t('site', 'users login ("Remember me" during a week)'), '/login') :
                                'users login ("Remember me" during a week)'; ?>;</li>
                        <li><?= $user->can(User::ROLE_ADMIN) ? Html::a(Yii::t('site', 'users management (changing user role and status)')
                                , '/user/management') : 'users management (changing user role and status)'; ?>;</li>
                        <li><?= $user->can(User::ROLE_ADMIN) ? Html::a(Yii::t('site', 'mail templates management (modifying templates)'),
                                '/mail-template') : 'mail templates management (modifying templates)'; ?>;</li>
                        <li><?= $user->can(User::ROLE_ADMIN) ? Html::a(Yii::t('site', 'static pages management (modifying content)'),
                                '/static-pages') : 'static pages management (modifying content)'; ?>;</li>
                        <li><?= $user->isGuest ? 'users profiles (with ability of editing information)' :
                                Html::a(Yii::t('site', 'users profiles (with ability of editing information)'),
                                '/user/default/profile'); ?>.</li>
                    </ul>

                    <p><?= Yii::t('site', 'To test our application you may login as admin@admin.com/123456.'); ?></p>

                </div>

            </div>
        </div>

    </div>
</div>
