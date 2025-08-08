<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public ?string $store_name = null;

    public ?string $store_address = null;

    public static function group(): string
    {
        return 'app';
    }
}
