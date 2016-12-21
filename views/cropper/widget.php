<?php
/**
 * @var \yii\db\ActiveRecord $model
 * @var \budyaga\cropper\Widget $widget
 *
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;

?>

<div class="cropper-widget">
    <?= Html::activeHiddenInput($model, $widget->attribute, ['class' => 'photo-field']); ?>
    <?= Html::hiddenInput('width', $widget->width, ['class' => 'width-input']); ?>
    <?= Html::hiddenInput('height', $widget->height, ['class' => 'height-input']); ?>

    <?= Html::img(
        $model->{$widget->attribute} != ''
            ? $model->{$widget->attribute}
            : $widget->noPhotoImage,
        [
            'style' => 'height: ' . $widget->thumbnailHeight . 'px; width: ' . $widget->thumbnailWidth . 'px',
            'class' => 'thumbnail',
            'data-no-photo' => $widget->noPhotoImage,
        ]
    ); ?>
    <?php Modal::begin([
        'header' => '<h2>' . Yii::t('site', 'Change avatar') . '</h2>',
        'toggleButton' => [
            'tag' => 'button',
            'class' => 'btn btn-sm btn-info',
            'label' => Yii::t('site', 'Change avatar'),

        ],
    ]); ?>

    <div class="cropper-buttons">
        <button type="button" class="btn btn-sm btn-success crop-photo hidden"
                aria-label="<?= Yii::t('cropper', 'CROP_PHOTO'); ?>">
            <span class="glyphicon glyphicon-scissors" aria-hidden="true"></span>
            <?= Yii::t('cropper', 'CROP_PHOTO'); ?>
        </button>
        <button type="button" class="btn btn-sm btn-info upload-new-photo hidden"
                aria-label="<?= Yii::t('cropper', 'UPLOAD_ANOTHER_PHOTO'); ?>">
            <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
            <?= Yii::t('cropper', 'UPLOAD_ANOTHER_PHOTO'); ?>
        </button>
    </div>

    <div class="new-photo-area"
         style="height: <?= $widget->cropAreaHeight; ?>px; width: <?= $widget->cropAreaWidth; ?>px;">

        <div class="cropper-label">
            <span><?= $widget->label; ?></span>
        </div>
    </div>

    <div class="help-block help-block-error "></div>
    <div class="progress hidden" style="width: <?= $widget->cropAreaWidth; ?>px;">
        <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar"
             style="width: 0%">
            <span class="sr-only"></span>
        </div>
    </div>
    <?php Modal::end(); ?>
</div>