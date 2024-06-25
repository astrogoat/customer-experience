<?php

namespace Astrogoat\CustomerExperience\Components;

use Illuminate\View\Component;

class CxWidget extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('customer-experience::components.cx-widget');
    }
}
