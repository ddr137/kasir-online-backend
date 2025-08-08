<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use App\Filament\Widgets\SalesChart;
use Filament\Forms\Get;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends \Filament\Pages\Dashboard
{

    use HasFiltersForm;

    protected static ?string $title = 'Dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class
        ];
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->maxDate(now())
                            ->minDate(fn() => now()->subYears(1))
                            ->live(),
                        DatePicker::make('endDate')
                            ->minDate(fn(Get $get) => $get('startDate'))
                            ->maxDate(now())
                            ->after('startDate'),
                    ])
                    ->columns(2),
            ]);
    }
}
