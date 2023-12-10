<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\StatusModel;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function get_home_status()
    {
        /** @var User */
        $user = user();

        $idBefore = $this->request->getVar("idBefore");

        if ($idBefore == 0) {
            $idBefore = PHP_INT_MAX;
        }

        $query = "select status.*,
                         users.username,
                         profiles.display_name,
                         profiles.avatar
                  from status
                       left join users
                            on status.user_id = users.id
                       left join profiles
                            on profiles.id = users.id
                       left join connections
                            on connections.follower_user_id=?
                           and connections.following_user_id=users.id
                           and connections.following_user_id=status.user_id
                       left join status child_status
                            on child_status.parent_status_id=status.id
                  where status.id<?
                    and status.parent_status_id is null
                    and (connections.id is not null
                         or status.user_id=?)
                  group by status.id
                  order by status.id desc
                  limit 25";

        $result = model(StatusModel::class)->db->query($query, [$user->id, $idBefore, $user->id]);

        return $this->respond($result->getResultArray());
    }
}
