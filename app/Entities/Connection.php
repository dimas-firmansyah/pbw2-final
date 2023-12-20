<?php

namespace App\Entities;

use App\Models\UserModel;
use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $following_user_id
 * @property int $follower_user_id
 */
class Connection extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public static function create(int $following_user_id, int $follower_user_id): Connection
    {
        return new Connection([
            'following_user_id' => $following_user_id,
            'follower_user_id'  => $follower_user_id,
        ]);
    }

    public function getFollowing(): User
    {
        return model(UserModel::class)
            ->find($this->following_user_id);
    }

    public function getFollower(): User
    {
        return model(UserModel::class)
            ->find($this->follower_user_id);
    }
}
