<?php


class ManagementOptionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testOptionLoadToParamsSuccess()
    {
        $adminEmailFromDatabase = $this->tester->grabFromDatabase('options', 'value',
            ['namespace' => 'ADMIN', 'key' => 'email']
        );
        $adminEmailFromParams = Yii::$app->params['ADMIN']['email'];
        $this->tester->assertEquals($adminEmailFromDatabase, $adminEmailFromParams);
    }
}
