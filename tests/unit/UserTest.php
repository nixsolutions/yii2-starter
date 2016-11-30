<?php

use app\modules\user\models\forms\RegistrationForm;
use app\modules\user\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreateUser()
    {
        $user = new User();
        $form = new RegistrationForm();
        $form->firstName = 'test';
        $form->lastName = 'test';
        $form->email = 'test@test.com';
        $form->password = '123456';

        $user = $user->create($form);
        $this->assertNotEmpty($user);
    }
}