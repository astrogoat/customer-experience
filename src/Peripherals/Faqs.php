<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Helix\Lego\Settings\Peripherals\Peripheral;

class Faqs extends Peripheral
{
    public function render()
    {
        return view('customer-experience::peripherals.faqs');
    }
}
