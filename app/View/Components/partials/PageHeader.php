<?php

namespace App\View\Components\partials;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $homeRoute = 'dashboard',
        public array $breadcrumbs = [],
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.page-header');
    }
}
