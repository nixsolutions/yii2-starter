<?php

use app\modules\user\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function createUser()
    {
        $user = new User();
        $testData = [
            'first_name' => 'test',
            'last_name' => 'test',
            'password' => '123456',
            'email' => 'test@test.com',
        ];
        $user->create($testData);
        $this->assertNotEmpty($user->create($testData));
    }
}