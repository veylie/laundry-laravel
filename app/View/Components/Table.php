<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $headers;
    public $rows;
    public $actionComponent;
    public $withNumbering;
    public $routeName;


    /**
     * Create a new component instance.
     */
    public function __construct($rows, $actionComponent = null, $withNumbering = false, $routeName = null)
    {
        $rows = collect($rows);
        // ambil semua key dari data pertama
        $headers = $rows->isNotEmpty() ? array_keys((array) $rows->first()) : [];

        // buang 'id' dari headers supaya tidak ditampilkan
        $headers = array_filter($headers, fn($h) => $h !== 'id');



        $this->rows = $rows;
        $this->headers = $headers;
        $this->withNumbering = $withNumbering;
        $this->actionComponent = $actionComponent;
        $this->routeName = $routeName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}