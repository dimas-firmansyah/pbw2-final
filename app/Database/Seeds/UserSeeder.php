<?php

namespace App\Database\Seeds;

use App\Entities\User;
use App\Models\UserModel;
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
        $faker = Factory::create();
        $faker->seed(1234);

        $model = model(UserModel::class);

        $firstUser = new User([
            'email' => 'deirn@bai.lol',
            'username' => 'deirn',
            'password' => 'test',
        ]);
        $firstUser->activate();

        $model->insert($firstUser);

        for ($i = 0; $i < 49; $i++) {
            $user = $model->fake($faker);
            $user->activate();
            $model->insert($user);
        }
    }
}
