<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $totalVisitsToday = Visit::whereDate(
            'visit_date',
            Carbon::today(),
        )->count();
        $totalVisitsMonth = Visit::whereBetween('visit_date', [
            $currentMonthStart,
            $currentMonthEnd,
        ])->count();
        $totalVisitsPreviousMonth = Visit::whereBetween('visit_date', [
            $previousMonthStart,
            $previousMonthEnd,
        ])->count();

        $growthPercentage = 0;
        if ($totalVisitsPreviousMonth > 0) {
            $growthPercentage =
                (($totalVisitsMonth - $totalVisitsPreviousMonth) /
                    $totalVisitsPreviousMonth) *
                100;
        }

        $stats = [
            'total_visits_today' => $totalVisitsToday,
            'total_visits_month' => $totalVisitsMonth,
            'active_visitors' => Visit::where('status', 'in_progress')
                ->whereDate('visit_date', Carbon::today())
                ->count(),
            'pending_accepted' => Visit::where('status', 'pending')
                ->whereDate('visit_date', Carbon::today())
                ->count(),
            'growth_percentage' => round($growthPercentage, 1),
        ];
        $recentVisits = Visit::with('visitor')
            ->whereDate('visit_date', Carbon::today())
            ->orderBy('check_in', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($visit) {
                return [
                    'id' => $visit->id,
                    'visit_id' => $visit->visit_id,
                    'visitor_name' => $visit->visitor->full_name ?? 'N/A',
                    'purpose' => $visit->purpose,
                    'check_in' => $visit->check_in
                        ? Carbon::parse($visit->check_in)->format('H:i')
                        : '-',
                    'check_out' => $visit->check_out
                        ? Carbon::parse($visit->check_out)->format('H:i')
                        : null,
                    'status' => $visit->status,
                    'visit_date' => Carbon::parse($visit->visit_date)->format(
                        'Y-m-d',
                    ),
                ];
            })
            ->toArray();

        $topVisitorsData = Visit::select(
            'visitor_id',
            DB::raw('count(*) as visit_count'),
        )
            ->with('visitor')
            ->whereBetween('visit_date', [$currentMonthStart, $currentMonthEnd])
            ->whereNotNull('visitor_id')
            ->groupBy('visitor_id')
            ->orderBy('visit_count', 'desc')
            ->limit(4)
            ->get();

        $totalVisitorCount = $topVisitorsData->sum('visit_count');

        $topVisitors = $topVisitorsData
            ->map(function ($item) use ($totalVisitorCount) {
                $percentage =
                    $totalVisitorCount > 0
                    ? round(($item->visit_count / $totalVisitorCount) * 100)
                    : 0;

                return [
                    'visitor_name' => $item->visitor->full_name ?? 'N/A',
                    'phone_number' => $item->visitor->phone_number ?? '-',
                    'visit_count' => $item->visit_count,
                    'percentage' => $percentage,
                ];
            })
            ->toArray();

        $visitsByHourData = Visit::select(
            DB::raw('HOUR(check_in) as hour'),
            DB::raw('COUNT(*) as count'),
        )
            ->whereDate('visit_date', Carbon::today())
            ->whereNotNull('check_in')
            ->groupBy(DB::raw('HOUR(check_in)'))
            ->orderBy('hour')
            ->get();

        $visitsByHour = [];
        for ($hour = 8; $hour <= 17; $hour++) {
            $hourFormatted = sprintf('%02d:00', $hour);
            $count = $visitsByHourData->firstWhere('hour', $hour)?->count ?? 0;

            $visitsByHour[] = [
                'hour' => $hourFormatted,
                'count' => $count,
            ];
        }

        return view(
            'adminpage.dashboard',
            compact('stats', 'recentVisits', 'topVisitors', 'visitsByHour'),
        );
    }
}
