<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Status;
use App\Models\StatusModel;

class ViewController extends BaseController
{
    private function view(string $viewName, string $pageTitle, array $extra = [])
    {
        return view($viewName, [
            'viewName'  => $viewName,
            'pageTitle' => $pageTitle,
            ...$extra,
        ]);
    }

    public function root()
    {
        return redirect()->to('/home');
    }

    public function home()
    {
        return $this->view('home', 'Home');
    }

    public function profile(string $username)
    {
        return $this->view('profile', $username);
    }

    public function status(int $id)
    {
        $status = model(StatusModel::class)->find($id);

        return $this->view('status', 'Status', [
            'status'    => $status
        ]);
    }
}
