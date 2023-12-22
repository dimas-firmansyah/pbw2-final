<?php

namespace App\Cells;

use App\Entities\Profile;
use CodeIgniter\View\Cells\Cell;

class ProfileHeaderCell extends Cell
{
    public $val;

    public static function m(string $val)
    {
        return view_cell(self::class, [
            'val' => $val,
        ]);
    }
}
