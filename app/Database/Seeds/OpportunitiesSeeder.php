<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use ReflectionException;

class OpportunitiesSeeder extends Seeder
{
    /**
     * @throws ReflectionException
     */
    public function run()
    {
        $faker = Factory::create();

        $userModel = model('App\Models\User');
        $opportunityModel = model('App\Models\Opportunity');

        $recruitersCount = $userModel->where('role', 'recruiter')->countAllResults();

        if ($recruitersCount === 0) {
            $this->call('UserSeeder');
        }
        $recruiters = $userModel->select('id')->where('role', 'recruiter')->findAll();

        $recruiterIds = array_column($recruiters, 'id');

        for ($i = 0; $i < 10; $i++) {
            $opportunityData = [
                'title' => $faker->jobTitle(),
                'description' => $faker->text(),
                'recruiter_id' => $faker->randomElement($recruiterIds),
            ];

            $opportunityModel->insert($opportunityData);
        }
    }
}
