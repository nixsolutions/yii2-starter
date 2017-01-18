<?php
namespace app\assets;

use yii\web\AssetBundle;

class WysiwygAsset extends AssetBundle
{
    public $baseUrl = '@web';

    public $basePath = '@vendor';

    public $js = [
        'ckeditor/ckeditor/plugins/justify/plugin.js',
    ];

    public $depends = [
        'dosamigos\ckeditor\CKEditorWidgetAsset',
        'app\assets\AppAsset',
    ];
}
