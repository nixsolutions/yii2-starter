<?php

namespace app\widgets\crop\assets;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower';

    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';

    /**
     * @inheritdoc
     */
    public $js = [
        'cropper/dist/cropper.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'cropper/dist/cropper.css',
    ];
}
