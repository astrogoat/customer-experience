<?php

namespace VendorName\Skeleton\Settings;

use VendorName\Skeleton\Actions\SkeletonAction;
use Helix\Lego\Settings\AppSettings;

class SkeletonSettings extends AppSettings
{
    // public string $url;
    // public string $access_token;

    protected array $rules = [
        // 'url' => ['required', 'url'],
        // 'access_token' => ['required'],
    ];

    protected static array $actions = [
        // SkeletonAction::class,
    ];

    // public static function encrypted(): array
    // {
    //     return ['access_token'];
    // }

    public function description(): string
    {
        return 'Interact with Skeleton.';
    }
}
