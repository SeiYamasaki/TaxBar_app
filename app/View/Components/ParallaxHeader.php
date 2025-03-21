<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ParallaxHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $backgroundImage = '/images/bar_8.jpeg'
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.parallax-header');
    }
}
