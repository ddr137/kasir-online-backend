<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('app.store_name', 'Hiperkreatif Store');
        $this->migrator->add('app.store_address', 'Jl. Hiperkreatif No. 123');
    }
};
