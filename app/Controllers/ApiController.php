<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Engagement;
use App\Entities\Status;
use App\Models\EngagementModel;
use App\Models\StatusModel;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function get_home_status()
    {
        $userId = user_id();
        $idBefore = $this->request->getVar('idBefore');

        if ($idBefore == 0) {
            $idBefore = PHP_INT_MAX;
        }

        $query = "select status.*,
                         users.username,
                         profiles.display_name,
                         profiles.avatar,
                         count(distinct engagements.id) as like_count,
                         count(distinct child_status.id) as child_count,
                         count(distinct liked.id) as liked
                  from status
                       left join users
                            on status.user_id = users.id
                       left join profiles
                            on profiles.id = users.id
                       left join connections
                            on connections.follower_user_id=?
                           and connections.following_user_id=users.id
                           and connections.following_user_id=status.user_id
                       left join engagements
                            on status.id=engagements.status_id
                       left join status child_status
                            on child_status.parent_status_id=status.id
                       left join engagements liked
                            on status.id=liked.status_id
                           and liked.user_id=?
                  where status.id<?
                    and status.parent_status_id is null
                    and (connections.id is not null
                         or status.user_id=?)
                  group by status.id
                  order by status.id desc
                  limit 25";

        $result = model(StatusModel::class)->db->query($query, [$userId, $userId, $idBefore, $userId]);

        return $this->respond($result->getResultArray());
    }

    public function like()
    {
        $userId = user_id();
        $statusId = $this->request->getVar('statusId');

        /** @var Status */
        $status = model(StatusModel::class)->find($statusId);

        $engagementModel = model(EngagementModel::class);
        $engagement = $status->getEngagementFor($userId);

        if ($engagement == null) {
            $engagementModel->save(Engagement::create($userId, $statusId));
        } else {
            $engagementModel->delete($engagement->id);
        }

        return $this->respond([
            'liked'        => $engagement == null,
            'newLikeCount' => $status->getLikeCount(),
        ]);
    }
}
