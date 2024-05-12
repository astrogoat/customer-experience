<?php

namespace Astrogoat\CustomerExperience\Settings;

use Astrogoat\CustomerExperience\Peripherals\Faqs;
use Astrogoat\CustomerExperience\Peripherals\Support;
use Astrogoat\CustomerExperience\Peripherals\SupportLinks;
use Helix\Lego\Settings\AppSettings;

class CustomerExperienceSettings extends AppSettings
{
    protected array $peripherals = [
        Support::class,
        Faqs::class,
        SupportLinks::class,
    ];

    public function description(): string
    {
        return 'Interact with Customer Experience.';
    }

    public static function group(): string
    {
        return 'customer-experience';
    }
}
