<?php

namespace Tests\Feature;

use App\Models\User;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class UserControllerTest extends CustomTestBase
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

    public function testCreateUser()
    {
        $payload = json_encode([
            'username' => 'newuser',
            'password' => 'newpassword',
            'role' => 'recruiter',
        ]);

        $result = $this->withBody($payload)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('api/user/register');

        $this->assertTrue($result->isOK());
        $this->seeInDatabase('users', ['username' => 'newuser']);
    }

    public function testShowUser()
    {
        $userModel = new User();

        $user = $userModel->where('username', 'testuser')->first();

        $this->assertNotNull($user, 'User not found.');

        if ($user) {
            $userId = $user['id'];

            $result = $this->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ])->get('api/user/profile/' . $userId);

            $this->assertTrue($result->isOK());
            $responseData = json_decode($result->getJSON(), true);

            $this->assertArrayHasKey('username', $responseData);
            $this->assertArrayNotHasKey('password', $responseData);
        }
    }

    public function testUpdateUser()
    {
        $userId = 1;
        $payload = json_encode([
            'username' => 'updateduser',
            'password' => 'updatedpassword',
        ]);

        $result = $this->withBody($payload)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ])->put('api/user/update/' . $userId);

        $this->assertTrue($result->isOK());
        $this->seeInDatabase('users', ['id' => $userId, 'username' => 'updateduser']);
    }
}
