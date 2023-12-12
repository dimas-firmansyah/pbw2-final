<?php

namespace App\Database\Seeds;

use App\Entities\Engagement;
use App\Entities\Status;
use App\Entities\User;
use App\Models\EngagementModel;
use App\Models\StatusModel;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory;

class EngagementSeeder extends Seeder
{
    public function run()
    {
        echo 'Seeding Engagements' . PHP_EOL;

        $faker = Factory::create();
        $faker->seed(1234);

        $userModel = model(UserModel::class);
        $statueModel = model(StatusModel::class);
        $engagementModel = model(EngagementModel::class);

        /** @var User[] */
        $users = $userModel->findAll();

        /** @var Status[] */
        $statuses = $statueModel->findAll();

        foreach ($statuses as $status) {
            $totalEngagement = $faker->numberBetween(0, 5);
            $likingUsername = [];

            for ($i = 0; $i < $totalEngagement; $i++) {
                while (true) {
                    $userId = $faker->numberBetween(0, count($users) - 1);
                    $user = $users[$userId];
                    if (isset($likingUsername[$user->username])) continue;

                    $engagementModel->save(Engagement::create($user->id, $status->id));
                    
                    $likingUsername[$user->username] = true;
                    break;
                }
            }
        }
    }
}
