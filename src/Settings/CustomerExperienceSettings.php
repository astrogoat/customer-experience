<?php

namespace Astrogoat\CustomerExperience\Settings;

use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class CustomerExperienceSettings extends AppSettings
{
    // public string $url;

    protected array $rules = [
        // 'url' => Rule::requiredIf($this->enabled === true),
    ];

    public function description(): string
    {
        return 'Interact with CustomerExperience.';
    }

    public static function group(): string
    {
        return 'customer-experience';
    }
}
