<?php

namespace App\Database\Seeds;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        echo 'Seeding Users' . PHP_EOL;

        $faker = Factory::create();
        $faker->seed(1234);

        $model = model(UserModel::class);

        $firstUser = new User([
            'email'    => 'deirn@bai.lol',
            'username' => 'deirn',
            'password' => 'test',
        ]);
        $firstUser->activate();
        $model->insert($firstUser);
        echo "  {$firstUser->username}" . PHP_EOL;

        for ($i = 0; $i < 49; $i++) {
            $user = $model->fake($faker);
            $user->activate();
            $model->insert($user);
            echo "  {$user->username}" . PHP_EOL;
        }
    }
}
