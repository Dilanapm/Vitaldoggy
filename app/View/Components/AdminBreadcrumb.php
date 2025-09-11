<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminBreadcrumb extends Component
{
    public $items;
    public $currentPage;

    public function __construct($items = [], $currentPage = '')
    {
        $this->items = $items;
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.admin-breadcrumb');
    }
}