<?php

namespace app\assets;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $basePath = '@webroot';

    public $js = [
        'cropper/dist/cropper.js',
    ];

    public $css = [
        'cropper/dist/cropper.css',
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
}
