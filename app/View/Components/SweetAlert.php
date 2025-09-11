<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SweetAlert extends Component
{
    public $type;
    public $title;
    public $text;
    public $confirmButtonText;
    public $cancelButtonText;
    public $confirmCallback;
    public $icon;
    public $showCancelButton;

    public function __construct(
        $type = 'confirm',
        $title = '¿Estás seguro?',
        $text = '',
        $confirmButtonText = 'Sí, continuar',
        $cancelButtonText = 'Cancelar',
        $confirmCallback = '',
        $icon = 'warning',
        $showCancelButton = true
    ) {
        $this->type = $type;
        $this->title = $title;
        $this->text = $text;
        $this->confirmButtonText = $confirmButtonText;
        $this->cancelButtonText = $cancelButtonText;
        $this->confirmCallback = $confirmCallback;
        $this->icon = $icon;
        $this->showCancelButton = $showCancelButton;
    }

    public function render()
    {
        return view('components.sweet-alert');
    }
}
