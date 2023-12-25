<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ProfileHeaderCell extends Cell
{
    public $val;
    public $enableBackButton;

    public static function m(string $val, bool $enableBackButton = true)
    {
        return view_cell(self::class, [
            'val'              => $val,
            'enableBackButton' => $enableBackButton,
        ]);
    }
}
