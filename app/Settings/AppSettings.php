<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public string $store_name;

    public string $store_address;

    public ?string $paper_size = '58mm';

    public static function group(): string
    {
        return 'app';
    }
}
