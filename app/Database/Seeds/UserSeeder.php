<?php

namespace App\Database\Seeds;

use App\Models\User;
use CodeIgniter\Database\Seeder;
use Faker\Factory;
use ReflectionException;

class UserSeeder extends Seeder
{
    /**
     * @throws ReflectionException
     */
    public function run()
    {
        $userModel = new User();
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $userData = [
                'username' => $faker->userName,
                'password' => password_hash('secret', PASSWORD_DEFAULT),
                'role' => $faker->randomElement(['talent', 'recruiter']),
            ];

            $userModel->insert($userData);
        }
    }
}
