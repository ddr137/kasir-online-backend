<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = '15s';
    protected static bool $isLazy = true;

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        // Ambil filter dari request jika ada
        $startDate = $this->filters['startDate'];
        $endDate = $this->filters['endDate'];

        // Parse ke Carbon (biar valid)
        $start = $startDate ? Carbon::parse($startDate) : now()->startOfMonth();
        $end = $endDate ? Carbon::parse($endDate) : now();

        // Total Sales = semua transaksi
        $totalSales = Transaction::whereBetween('created_at', [$start, $end])->count();

        // Pending & Completed
        $pending = Transaction::where('status', 'pending')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $completed = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $cancelled = Transaction::where('status', 'cancelled')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $revenue = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_price');

        return [
            Stat::make('Pending', $pending)
                ->description('Belum diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Completed', $completed)
                ->description('Selesai dibayar')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('secondary'),

            Stat::make('Cancelled', $cancelled)
                ->description('Dibatalkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Revenue', rupiah($revenue))
                ->description('Total Pendapatan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
