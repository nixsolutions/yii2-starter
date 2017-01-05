<?php

namespace app\widgets\crop;

use app\widgets\crop\assets\CropAsset;
use Yii;
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
        self::registerTranslations();
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

    /**
     * Register widget translations.
     */
    public static function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['crop'])) {
            Yii::$app->i18n->translations['crop'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
