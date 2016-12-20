<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use phpnt\cropper\ImageLoadWidget;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/modules/user/registration.css', ['depends' => [BootstrapAsset::className()]]);

$this->title = Yii::t('user', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title); ?></h1>

    <p>Please fill out the following fields for registration:</p>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'firstName')->textInput(['autofocus' => true]); ?>

    <?= $form->field($model, 'lastName')->textInput(); ?>

    <?= $form->field($model, 'email')->textInput(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput(); ?>



    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton(Yii::t('user', 'Register'),
                ['class' => 'btn btn-primary', 'name' => 'register-button']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?= ImageLoadWidget::widget([
        'id' => 'load-user-avatar',              // суффикс ID
//        'object_id' => $user->id,                // ID объекта
//        'imagesObject' => $user->photos,         // уже загруженные изображения
        'images_num' => 1,                       // максимальное количество изображений
//        'images_label' => $user->avatar_label,   // метка для изображения
        'imageSmallWidth' => 750,                // ширина миниатюры
        'imageSmallHeight' => 750,               // высота миниатюры
        'imagePath' => '/uploads/avatars/',      // путь, куда будут записыватся изображения относительно алиаса
        'noImage' => 2,                          // 1 - no-logo, 2 - no-avatar, 3 - no-img или путь к другой картинке
        'buttonClass'=> 'btm btn-info',// класс кнопки "обновить аватар"/"загрузить аватар" / по умолчанию btm btn-info
        'previewSize'=> 'file',                  // размер изображения для превью(либо file_small, либо просто file)
        'pluginOptions' => [                     // настройки плагина
            'aspectRatio' => 1/1, // установите соотношение сторон рамки обрезки. По умолчанию свободное отношение.
            'strict' => false,                   // true - рамка не может вызодить за холст, false - может
            'guides' => true,                    // показывать пунктирные линии в рамке
            'center' => true,                    // показывать центр в рамке изображения изображения
            'autoCrop' => true,                  // показывать рамку обрезки при загрузке
            'autoCropArea' => 0.5,               // площидь рамки на холсте изображения при autoCrop (1 = 100% - 0 - 0%)
            'dragCrop' => false, // создание новой рамки при клики в свободное место хоста (false - нельзя)
            'movable' => true,                   // перемещать изображение холста (false - нельзя)
            'rotatable' => true,                 // позволяет вращать изображение
            'scalable' => true,                  // мастабирование изображения
            'zoomable' => false,
        ]]);
    ?>

</div>
