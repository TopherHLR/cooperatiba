<?php
namespace App\Http\Controllers;

use App\Models\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = Carbon::now();
        // Determine default academic year based on current date
        if ($today->month >= 8) {
            $defaultStartYear = $today->year;
        } else {
            $defaultStartYear = $today->year - 1;
        }
        // Get selected academic year from request, fallback to default
        $selectedAcademicYear = $request->input('academic_year', $defaultStartYear);
        Log::info('Request Input: ', $request->all());
        Log::info('Selected Academic Year: ' . $selectedAcademicYear);

        // Generate academic years (e.g., 2024-2025 to 2019-2020)
        $academicYears = [];
        for ($year = $today->year; $year >= 2019; $year--) {
            $academicYears[] = ['startYear' => $year];
        }

        // Set date range based on selected academic year
        $startDate = Carbon::create($selectedAcademicYear, 8, 1)->startOfDay();
        $endDate = $startDate->copy()->addYear()->subDay()->endOfDay();
        Log::info("Date Range: $startDate to $endDate");

        // Status counts
        $sort = $request->input('sort', 'total');
        $statusCounts = [
            'total' => OrderModel::whereBetween('order_date', [$startDate, $endDate])->count(),
            'pending' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'pending')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'paid' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'paid')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'processing' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'processing')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'readyforpickup' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'readyforpickup')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'completed' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'completed')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'cancelled' => OrderModel::whereHas('statusHistories', fn($q) => $q->where('status', 'cancelled')
                ->where('is_current', true)
                ->whereBetween('updated_at', [$startDate, $endDate]))->count(),
            'total_uniforms_sold' => \App\Models\OrderItemModel::whereHas('order', fn($q) => $q->whereBetween('order_date', [$startDate, $endDate]))->sum('quantity'),
            'average_order_value' => OrderModel::whereBetween('order_date', [$startDate, $endDate])->avg('total_price'),
        ];
        Log::info('Status Counts: ', $statusCounts);
        Log::info('Orders for A.Y. ' . $selectedAcademicYear . '-' . ($selectedAcademicYear + 1) . ': ' . $statusCounts['total']);

        // Sort status counts
        arsort($statusCounts);
        if ($sort && array_key_exists($sort, $statusCounts)) {
            $sortedCounts = [$sort => $statusCounts[$sort]];
            foreach ($statusCounts as $key => $value) {
                if ($key !== $sort) {
                    $sortedCounts[$key] = $value;
                }
            }
            $statusCounts = $sortedCounts;
        }

        // Average order price per day
        $avgPerDay = OrderModel::selectRaw('DATE(order_date) as date, AVG(total_price) as avg_price')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(order_date)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        Log::info('avgPerDay count: ' . $avgPerDay->count());

        $avgData = [];
        $labels = [];
        $currentDate = $endDate->copy()->subDays(30); // Limit to last 30 days of A.Y.
        while ($currentDate <= $endDate) {
            $date = $currentDate->toDateString();
            $labels[] = $currentDate->format('M d');
            $value = isset($avgPerDay[$date]) ? round($avgPerDay[$date]->avg_price, 2) : null;
            $avgData[] = $value;
            $currentDate->addDay();
        }
        Log::info('avgData: ', $avgData);
        Log::info('labels: ', $labels);

        return view('dashboard', compact('statusCounts', 'avgData', 'labels', 'startDate', 'endDate', 'academicYears', 'selectedAcademicYear'));
    }
}