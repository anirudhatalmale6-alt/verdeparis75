<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $thirtyDaysAgo = $now->copy()->subDays(30);

        $onlineNow = PageVisit::where('created_at', '>=', $now->copy()->subMinutes(5))
            ->distinct('ip_address')
            ->count('ip_address');

        $visitsToday = PageVisit::whereDate('created_at', $now->toDateString())->count();
        $pageViewsToday = PageVisit::whereDate('created_at', $now->toDateString())->count();
        $uniqueToday = PageVisit::whereDate('created_at', $now->toDateString())
            ->distinct('ip_address')
            ->count('ip_address');

        $visitsWeek = PageVisit::where('created_at', '>=', $now->copy()->startOfWeek())->count();
        $visitsMonth = PageVisit::where('created_at', '>=', $now->copy()->startOfMonth())->count();
        $uniqueMonth = PageVisit::where('created_at', '>=', $now->copy()->startOfMonth())
            ->distinct('ip_address')
            ->count('ip_address');

        $totalVisits = PageVisit::count();
        $uniqueVisitors = PageVisit::distinct('ip_address')->count('ip_address');

        $visitsPerDay = PageVisit::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as visits')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('visits', 'date')
            ->toArray();

        $dailyVisits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dailyVisits[] = ['date' => $date, 'visits' => $visitsPerDay[$date] ?? 0];
        }

        $topPages = PageVisit::select(
            'page_url',
            DB::raw('COUNT(*) as visit_count'),
            DB::raw('COUNT(DISTINCT ip_address) as unique_count')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('page_url')
            ->orderByDesc('visit_count')
            ->take(15)
            ->get()
            ->map(function ($page) use ($visitsMonth) {
                $page->percentage = $visitsMonth > 0 ? round(($page->visit_count / $visitsMonth) * 100, 1) : 0;
                return $page;
            });

        $deviceBreakdown = PageVisit::select(
            'device_type',
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();

        $referrerStats = PageVisit::select(
            'referer',
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->groupBy('referer')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        $hourlyToday = PageVisit::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
            ->whereDate('created_at', $now->toDateString())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();

        $hourlyData = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyData[] = ['hour' => sprintf('%02d:00', $h), 'count' => $hourlyToday[$h] ?? 0];
        }

        $recentVisitors = PageVisit::select('ip_address', 'page_url', 'device_type', 'created_at')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('admin.analytics.index', compact(
            'onlineNow',
            'visitsToday',
            'pageViewsToday',
            'uniqueToday',
            'visitsWeek',
            'visitsMonth',
            'uniqueMonth',
            'totalVisits',
            'uniqueVisitors',
            'dailyVisits',
            'topPages',
            'deviceBreakdown',
            'referrerStats',
            'hourlyData',
            'recentVisitors'
        ));
    }
}
