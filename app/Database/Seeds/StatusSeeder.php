<?php

namespace App\Database\Seeds;

use App\Entities\Status;
use App\Entities\User;
use App\Models\StatusModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $faker->seed(1234);

        $userModel = model(UserModel::class);
        $statusModel = model(StatusModel::class);

        /** @var User[] */
        $users = $userModel->findAll();

        foreach ($users as $user) {
            $totalStatus = $faker->numberBetween(1, 5);

            for ($i = 0; $i < $totalStatus; $i++) {
                $status = Status::create($user->id, $faker->text(280));
                $statusModel->insert($status);
            }
        }

        /** @var Status[] */
        $parentStatus = $statusModel->findAll();

        foreach ($parentStatus as $parent) {
            $totalReply = $faker->numberBetween(1, 5);

            for ($i = 0; $i < $totalReply; $i++) {
                $userIndex = $faker->numberBetween(0, count($users) - 1);
                $user = $users[$userIndex];

                $reply = Status::create($user->id, $faker->text(280), $parent->id);
                $statusModel->insert($reply);
            }
        }
    }
}
