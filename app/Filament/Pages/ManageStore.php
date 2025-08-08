<?php

namespace App\Filament\Pages;

use App\Settings\AppSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageStore extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = AppSettings::class;

    public function form(Form $form): Form
    {
        $settings = app(AppSettings::class);

        return $form
            ->schema([
                Forms\Components\Section::make('Store Information')
                    ->schema([
                        Forms\Components\TextInput::make('store_name')
                            ->label('Store Name')
                            ->default(fn () => $settings->store_name)
                            ->required(),
                        Forms\Components\TextInput::make('store_address')
                            ->label('Store Address')
                            ->default(fn () => $settings->store_address)
                            ->required(),
                    ]),
            ]);
    }
}
