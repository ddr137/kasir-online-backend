<?php

namespace App\Filament\Widgets;

use App\Models\Bank;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class BanksChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Banks';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $startDate = isset($this->filters['startDate']) ? Carbon::parse($this->filters['startDate']) : now()->startOfMonth();
        $endDate = isset($this->filters['endDate']) ? Carbon::parse($this->filters['endDate']) : now();

        $paymentMethods = PaymentMethod::all();
        $transactionPaymentData = $paymentMethods->mapWithKeys(function ($method) use ($startDate, $endDate) {
            $total = Transaction::where('payment_method_id', $method->id)
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->count();

            return [$method->name => $total];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Total Payment Methods',
                    'data' => $transactionPaymentData->values()->toArray(),
                ],
            ],
            'labels' => $paymentMethods->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
