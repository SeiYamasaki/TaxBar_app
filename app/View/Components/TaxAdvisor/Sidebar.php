<?php

namespace App\View\Components\TaxAdvisor;

use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $user
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.tax-advisor.sidebar');
    }
}
