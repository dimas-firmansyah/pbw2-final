<?php

namespace App\Entities;

use App\Models\StatusModel;
use App\Models\UserModel;
use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 */
class Engagement extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public static function create(int $user_id, int $status_id): Engagement
    {
        return new Engagement([
            'user_id'   => $user_id,
            'status_id' => $status_id,
        ]);
    }

    public function getStatus(): Status
    {
        return model(StatusModel::class)->find($this->status_id);
    }

    public function getUser(): User
    {
        return model(UserModel::class)->find($this->user_id);
    }
}
