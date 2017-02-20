<?php
namespace tests\codeception\fixtures;

use yii\test\ActiveFixture;

class MailTemplateFixture extends ActiveFixture
{
    public $modelClass = 'app\modules\mailTemplate\models\MailTemplate';
    public $dataFile = '@tests/codeception/fixtures/data/mailTemplate.php';
}