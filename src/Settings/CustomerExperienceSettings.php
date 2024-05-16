<?php

namespace Astrogoat\CustomerExperience\Settings;

use Astrogoat\CustomerExperience\Peripherals\Faqs;
use Astrogoat\CustomerExperience\Peripherals\Support;
use Astrogoat\CustomerExperience\Peripherals\SupportLinks;
use Helix\Lego\Settings\AppSettings;

class CustomerExperienceSettings extends AppSettings
{
    public bool $chat_enabled;
    public bool $call_enabled;

    public function rules()
    {
        return [
          'chat_enabled' => ['nullable','boolean'],
          'call_enabled' => ['nullable','boolean'],
        ];
    }

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
