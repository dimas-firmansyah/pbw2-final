<?php

namespace App\Database\Seeds;

use App\Entities\Connection;
use App\Entities\User;
use App\Models\ConnectionModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ConnectionSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $faker->seed(1234);

        $userModel = model(UserModel::class);
        $connectionModel = model(ConnectionModel::class);
        $users = $userModel->findAll();

        foreach ($users as $index => $user) {
            $totalFollowing = $faker->numberBetween(5, 30);
            $followed = [];

            for ($i = 1; $i <= $totalFollowing; $i++) {
                while (true) {
                    $targetIndex = $faker->numberBetween(0, count($users) - 1);
                    if ($targetIndex == $index) {
                        continue;
                    }

                    $targetUser = $users[$targetIndex];
                    if (isset($followed[$targetUser->username])) {
                        continue;
                    }

                    $connectionModel->insert(new Connection([
                        "follower_user_id" => $user->id,
                        "following_user_id" => $targetUser->id,
                    ]));

                    $followed[$targetUser->username] = true;
                    break;
                }
            }
        }
    }
}
