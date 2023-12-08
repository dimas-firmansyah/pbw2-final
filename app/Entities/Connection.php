<?php

namespace App\Entities;

use App\Models\UserModel;
use CodeIgniter\Entity\Entity;

class Connection extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getFollowing(): User {
        /** @var UserModel */
        $user = model(UserModel::class);
        return $user->find($this->following_user_id);
    }

    public function getFollower(): User {
        /** @var UserModel */
        $user = model(UserModel::class);
        return $user->find($this->follower_user_id);
    }
}
