<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TransactionsChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Transactions';

    protected static ?string $pollingInterval = '15s';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $startDate = isset($this->filters['startDate']) ? Carbon::parse($this->filters['startDate']) : now()->startOfMonth();
        $endDate = isset($this->filters['endDate']) ? Carbon::parse($this->filters['endDate']) : now();


        $data = Trend::model(Transaction::class)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(function (TrendValue $value) use ($data) {
                if (count($data) > 7) {
                    return \Carbon\Carbon::parse($value->date)->format('d M');
                } else {
                    // Format to "Mon", "Tue", etc.
                    return \Carbon\Carbon::parse($value->date)->format('l');
                }
            }),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
