<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{

    public function index()
    {
        // Define date range (e.g., for Academic Year)
        $startDate = \Carbon\Carbon::createFromDate(2024, 8, 1)->startOfDay(); // Adjust as needed
        $endDate = \Carbon\Carbon::createFromDate(2025, 7, 31)->endOfDay(); // Adjust as needed

        // Status counts with is_current and date range
        $statusCounts = [
            'total' => \App\Models\OrderModel::whereBetween('order_date', [$startDate, $endDate])->count(),
            'pending' => \App\Models\OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'pending')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'paid' => \App\Models\OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'paid')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'processing' => \App\Models\OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'processing')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'readyforpickup' => \App\Models\OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'readyforpickup')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'completed' => \App\Models\OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'completed')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'cancelled' => \App\Models\OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'cancelled')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'total_uniforms_sold' => \App\Models\OrderItemModel::whereHas('order', fn($q) => $q->whereBetween('order_date', [$startDate, $endDate]))->sum('quantity'),
        ];

        // Average order price per day (last 7 days)
        $days = 7;
        $avgPerDay = \App\Models\OrderModel::selectRaw('DATE(order_date) as date, AVG(total_price) as avg_price')
            ->where('order_date', '>=', \Carbon\Carbon::now()->subDays($days))
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');


        $avgData = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $carbonDate = \Carbon\Carbon::now()->subDays($i);
            $date = $carbonDate->toDateString(); // 'YYYY-MM-DD'
            $labels[] = $carbonDate->format('M d');
            $value = isset($avgPerDay[$date]) ? round($avgPerDay[$date]->avg_price, 2) : null;
            $avgData[] = $value;

            \Log::info("Date: $date | Avg: $value");
        }

        return view('dashboard', compact('statusCounts', 'avgData', 'labels'));
    }

}