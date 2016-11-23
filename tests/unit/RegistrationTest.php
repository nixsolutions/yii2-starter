<?php

use app\modules\user\models\forms\RegistrationForm;

class RegistrationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUserRegistration()
    {
        $form = new RegistrationForm();
        $form->firstName = 'test';
        $form->lastName = 'test';
        $form->email = 'test@test.com';
        $form->password = '1234561';
        $form->passwordRepeat = '123456';
        $form->register();
        $this->assertArrayHasKey('user_id', $form->register());
        $this->assertArrayHasKey('hash', $form->register());
    }


}