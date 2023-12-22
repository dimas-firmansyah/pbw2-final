<?php

namespace App\Models;

use App\Entities\Profile;
use CodeIgniter\Model;

/**
 * @method ?Profile first()
 * @method ?Profile find($id = null)
 * @method Profile[] findAll()
 */
class ProfileModel extends Model
{
    protected $table            = 'profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = Profile::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'display_name', 'avatar', 'bio'];

    // Dates
    protected $useTimestamps = false;
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
                users.username,
                profiles.*,
                count(distinct followed.id) as followed,
                count(distinct following.id) as following,
                SQL)
            ->join('users',<<<SQL
                profiles.id = users.id
                SQL)
            ->join('connections followed',<<<SQL
                    followed.follower_user_id = ?
                and followed.following_user_id = users.id
                SQL,'left',false)
            ->join('connections following',<<<SQL
                    following.follower_user_id = users.id
                and following.following_user_id = ?
                SQL,'left',false);
    }

    public function runDetailsQuery(string $query, string $userId, ...$binds)
    {
        return $this->db->query($query, [$userId, $userId, ...$binds]);
    }
}
