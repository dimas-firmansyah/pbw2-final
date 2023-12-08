<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class NavBarCell extends Cell
{
    private $active;

    public function active(string $view): string
    {
        return $this->active == $view ? 'active' : '';
    }
}
