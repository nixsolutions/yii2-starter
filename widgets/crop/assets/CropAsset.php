<?php

namespace app\widgets\crop\assets;

use yii\web\AssetBundle;

class CropAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/widgets/crop/web';

    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/main.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/main.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'app\assets\AppAsset',
        'app\widgets\crop\assets\CropperAsset'
    ];

}
