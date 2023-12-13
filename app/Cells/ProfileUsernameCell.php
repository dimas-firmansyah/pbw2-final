<?php

namespace App\Cells;

use App\Entities\User;
use CodeIgniter\View\Cells\Cell;

class ProfileUsernameCell extends Cell
{
    public $user;

    public static function m(User $user)
    {
        return view_cell(self::class, [
            'user' => $user,
        ]);
    }
}
