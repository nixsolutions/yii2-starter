<?php


use app\modules\user\models\Hash;

class HashTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testGenerateHash()
    {
        $hash = new Hash();
        $this->assertNotEmpty($hash->generate('register', 1));
    }

    public function testFindByUserID()
    {
        $this->assertNotEmpty(Hash::findByUserID(1));
    }
}