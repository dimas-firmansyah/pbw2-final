<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function r()
    {
        return redirect()->to('/home');
    }

    public function index()
    {
        $data = [
            'page_title' => 'Home'
        ];

        return view('home', $data);
    }
}
