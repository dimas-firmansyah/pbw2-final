<?php

namespace App\Cells;

use App\Entities\Profile;
use CodeIgniter\View\Cells\Cell;

class ProfileHeaderCell extends Cell
{
    public $profile;
    public $slot;

    public static function m(Profile $profile)
    {
        return view_cell(self::class, [
            'profile' => $profile,
        ]);
    }
}
