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
        $statusCounts = [
            'pending' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'pending'))->count(),
            'paid' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'paid'))->count(),
            'processing' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'processing'))->count(),
            'readyforpickup' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'readyforpickup'))->count(),
            'completed' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'completed'))->count(),
            'cancelled' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'cancelled'))->count(),
        ];

        $days = 7;
        $avgPerDay = OrderModel::selectRaw('DATE(order_date) as date, AVG(total_price) as avg_price')
            ->where('order_date', '>=', \Carbon\Carbon::now()->subDays($days))
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        Log::info('Average per day raw result:', $avgPerDay->toArray());

        $avgData = [];
        $labels = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $carbonDate = \Carbon\Carbon::now()->subDays($i);
            $date = $carbonDate->toDateString();  // 'YYYY-MM-DD'
            $labels[] = $carbonDate->format('M d');

            $value = isset($avgPerDay[$date]) ? round($avgPerDay[$date]->avg_price, 2) : null;
            $avgData[] = $value;

            Log::info("Date: $date | Avg: $value");
        }

        return view('dashboard', compact('statusCounts', 'avgData', 'labels'));
    }


}