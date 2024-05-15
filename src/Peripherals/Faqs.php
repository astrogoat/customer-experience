<?php

namespace Astrogoat\CustomerExperience\Peripherals;

use Astrogoat\CustomerExperience\Models\Faq;
use Helix\Lego\Settings\Peripherals\Peripheral;

class Faqs extends Peripheral
{
    public function render()
    {
        return view('customer-experience::peripherals.faqs');
    }
}
