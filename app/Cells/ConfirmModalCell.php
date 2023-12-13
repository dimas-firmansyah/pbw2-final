<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ConfirmModalCell extends Cell
{
    public $id;
    public $title;
    public $body;

    public static function m(string $id, string $title, string $body)
    {
        return view_cell(self::class, [
            'id'    => $id,
            'title' => $title,
            'body'  => $body,
        ]);
    }
}
