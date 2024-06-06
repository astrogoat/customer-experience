<?php

namespace Astrogoat\CustomerExperience\Settings;

use Astrogoat\CustomerExperience\Peripherals\Faqs;
use Astrogoat\CustomerExperience\Peripherals\OpeningHours;
use Astrogoat\CustomerExperience\Peripherals\SupportLinks;
use Helix\Lego\Settings\AppSettings;

class CustomerExperienceSettings extends AppSettings
{
    public bool $chat_enabled;
    public bool $call_enabled;
    public bool $faq_enabled;

    public function rules()
    {
        return [
          'chat_enabled' => ['nullable','boolean'],
          'call_enabled' => ['nullable','boolean'],
          'faq_enabled' => ['nullable','boolean'],
        ];
    }

    protected array $peripherals = [
        OpeningHours::class,
        Faqs::class,
        SupportLinks::class,
    ];

    public function labels(): array
    {
        return [
            'chat_enabled' => 'Enable Chat button',
            'call_enabled' => 'Enable Call button',
            'faq_enabled' => 'Enable FAQs',
        ];
    }

    public function help(): array
    {
        return [
            'chat_enabled' => 'Toggle to enable the Chat button',
            'call_enabled' => 'Toggle to enable the Call button',
            'faq_enabled' => 'Toggle to enable the FAQ section',
        ];
    }

    public function description(): string
    {
        return 'Interact with Customer Experience.';
    }

    public static function group(): string
    {
        return 'customer-experience';
    }
}
