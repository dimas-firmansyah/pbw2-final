<?php

namespace App\Entities;

use App\Models\EngagementModel;
use App\Models\UserModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

/**
 * @property int $id
 * @property ?int $user_id
 * @property ?int $parent_status_id
 * @property ?string $content
 * @property ?Time $created_at
 * @property ?Time $updated_at
 * @property ?Time $deleted_at
 */
class Status extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public static function create(int $user_id, string $content, ?int $parent_status_id = null): Status
    {
        return new Status([
            'user_id'          => $user_id,
            'content'          => $content,
            'parent_status_id' => $parent_status_id,
        ]);
    }

    public function isDeleted(): bool
    {
        return isset($this->deleted_at);
    }

    public function delete(): Status
    {
        $this->user_id = null;
        $this->content = null;
        $this->deleted_at = Time::now();
        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->isDeleted() ? null : model(UserModel::class)->find($this->user_id);
    }

    public function getLikeCount(): int
    {
        return model(EngagementModel::class)
            ->where('status_id', $this->id)
            ->countAllResults();
    }

    public function getEngagementFor(int $user_id): ?Engagement
    {
        return model(EngagementModel::class)
            ->where([
                'status_id' => $this->id,
                'user_id'   => $user_id,
            ])
            ->first();
    }
}
