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

        $statusModel = model(StatusModel::class);
        $query = $statusModel->getDetailsBuilder()
            ->join('connections', <<<SQL
                    connections.follower_user_id = ?
                and connections.following_user_id = users.id
                and connections.following_user_id = status.user_id
                SQL,'left',false)
            ->where(<<<SQL
                status.id < ?
                  and status.parent_status_id is null
                  and (connections.id is not null
                       or status.user_id=?)
                SQL)
            ->groupBy('status.id')
            ->orderBy('status.id','DESC')
            ->limit(25)
            ->getCompiledSelect();

        $result = $statusModel->runDetailsQuery($query, $userId, $userId, $idBefore, $userId);
        return $this->respond($result->getResultArray());
    }

    public function get_status_ancestor()
    {
        $userId = user_id();
        $statusId = $this->request->getVar('statusId');

        $result = [];
        $statusModel = model(StatusModel::class);

        $query = $statusModel->getDetailsBuilder()
            ->where('status.id=?')
            ->limit(1)
            ->getCompiledSelect();

        $status = $statusModel
            ->runDetailsQuery($query, $userId, $statusId)
            ->getFirstRow();

        while ($status->parent_status_id != null) {
            $status = $statusModel
                ->runDetailsQuery($query, $userId, $status->parent_status_id)
                ->getFirstRow();
            $result[] = $status;
        }

        return $this->respond($result);
    }

    public function get_reply()
    {
        $userId = user_id();
        $parentStatusId = $this->request->getVar('parentStatusId');
        $idBefore = $this->request->getVar('idBefore');

        if ($idBefore == 0) {
            $idBefore = PHP_INT_MAX;
        }

        $statusModel = model(StatusModel::class);
        $query = $statusModel->getDetailsBuilder()
            ->where(<<<SQL
                    status.parent_status_id = ?
                and status.id < ?
                SQL)
            ->groupBy('status.id')
            ->orderBy('status.id','DESC')
            ->limit(25)
            ->getCompiledSelect();

        $result = $statusModel->runDetailsQuery($query, $userId, $parentStatusId, $idBefore);
        return $this->respond($result->getResultArray());
    }

    private function _post_status(?int $parentStatusId)
    {
        $userId = user_id();
        $content = $this->request->getVar('content');

        $statusModel = model(StatusModel::class);
        $statusId = $statusModel->insert(Status::create($userId, $content, $parentStatusId));
        $query = $statusModel->getDetailsBuilder()
            ->where('status.id', $statusId)
            ->getCompiledSelect();

        $result = $statusModel->runDetailsQuery($query, $userId);
        return $this->respond($result->getFirstRow());
    }

    public function post_status()
    {
        return $this->_post_status(null);
    }

    public function post_reply()
    {
        $parentStatusId = $this->request->getVar('parentStatusId');
        return $this->_post_status($parentStatusId);
    }

    public function delete_status()
    {
        $statusId = $this->request->getVar('statusId');

        model(StatusModel::class)->delete($statusId);
        
        return $this->respond();
    }

    public function like()
    {
        $userId = user_id();
        $statusId = $this->request->getVar('statusId');

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
