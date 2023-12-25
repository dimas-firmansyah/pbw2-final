<?php

namespace App\Models;

use App\Entities\Status;
use CodeIgniter\Model;

/**
 * @method ?Status first()
 * @method ?Status find($id = null)
 * @method Status[] findAll()
 */
class StatusModel extends Model
{
    protected $table            = 'status';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Status::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'parent_status_id', 'content'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDetailsBuilder()
    {
        return $this->builder()
            ->select(<<<SQL
                status.*,
                users.username,
                profiles.display_name,
                profiles.avatar,
                count(distinct engagements.id) as like_count,
                count(distinct child_status.id) as child_count,
                count(distinct liked.id) as liked
                SQL)
            ->join('users',<<<SQL
                status.user_id = users.id
                SQL)
            ->join('profiles',<<<SQL
                profiles.id = users.id
                SQL)
            ->join('engagements',<<<SQL
                status.id = engagements.status_id
                SQL,'left')
            ->join('status child_status',<<<SQL
                child_status.parent_status_id = status.id
                SQL,'left')
            ->join('engagements liked',<<<SQL
                    status.id = liked.status_id
                and liked.user_id = ?
                SQL,'left',false);
    }

    public function runDetailsQuery(string $query, string $userId, ...$binds)
    {
        return $this->db->query($query, [$userId, ...$binds]);
    }
}
