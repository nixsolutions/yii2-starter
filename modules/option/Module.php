<?php

namespace app\modules\option;

use app\modules\option\models\Option;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * option module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\option\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty(Yii::$app->i18n->translations['option'])) {
            Yii::$app->i18n->translations['option'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
        Yii::$app->urlManager->addRules(require(__DIR__ . '/config/routes.php'));
        $this->loadOptions();
    }


    /**
     * Load options from database to Yii::$app->params
     */
    protected function loadOptions()
    {
        $params = Yii::$app->params;
        $options = Option::find()->all();
        $options = ArrayHelper::map($options, 'key', 'value', 'namespace');
        Yii::$app->params = ArrayHelper::merge($params, $options);
    }
}
