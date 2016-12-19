<?php

namespace app\modules\feedback;

use Yii;

/**
 * feedback module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\feedback\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty(Yii::$app->i18n->translations['feedback'])) {
            Yii::$app->i18n->translations['feedback'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
