<?php

namespace app\widgets\crop;

use app\widgets\crop\assets\CropAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class Crop extends Widget
{
    public $noPhotoUrl = '/img/no_image.png';
    public $uploadUrl;
    public $modalLabel;
    public $inputLabel = 'Choose';
    public $cropLabel = 'Done';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (null == $this->uploadUrl) {
            throw new InvalidConfigException('Missing attribute uploadUrl');
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
        return $this->render('crop', [
            'widget' => $this,
        ]);
    }

    /**
     * Register widget asset
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        CropAsset::register($view);
    }
}
