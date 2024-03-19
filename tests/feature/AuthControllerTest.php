<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class AuthControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrateOnce = true;
    protected $migrate = true;
    protected $refresh = true;
    protected $seedOnce = true;
    protected $seed = 'UserSeeder';

    protected $basePath = APPPATH . 'Database/';
    protected $namespace = 'App';

    public function testLoginUser()
    {
        $payload = json_encode([
            'username' => 'testuser',
            'password' => 'correctpassword',
        ]);

        $result = $this->withBody($payload)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('api/auth/login');

        $this->assertTrue($result->isOK());
        $responseData = json_decode($result->getJSON(), true);
        $this->assertEquals('Login successful', $responseData['message']);

        $this->assertArrayHasKey('token', $responseData);
        $this->assertNotEmpty($responseData['token']);

        $tokenParts = explode('.', $responseData['token']);
        $this->assertCount(3, $tokenParts, 'The token must have 3 parts separated by dots.');
    }
}
