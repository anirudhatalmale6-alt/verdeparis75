<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard with charts data.
     */
    public function index()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Visits per day (last 30 days)
        $visitsPerDay = PageVisit::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing days with zero
        $dailyVisits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dailyVisits[$date] = $visitsPerDay[$date] ?? 0;
        }

        // Top pages (most visited)
        $topPages = PageVisit::select(
            'page_url',
            'page_title',
            DB::raw('COUNT(*) as visit_count')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('page_url', 'page_title')
            ->orderByDesc('visit_count')
            ->take(10)
            ->get();

        // Device breakdown
        $deviceBreakdown = PageVisit::select(
            'device_type',
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();

        // Referrer stats
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

        // Summary totals
        $totalVisits = PageVisit::where('created_at', '>=', $thirtyDaysAgo)->count();
        $uniqueVisitors = PageVisit::where('created_at', '>=', $thirtyDaysAgo)
            ->distinct('ip_address')
            ->count('ip_address');

        return view('admin.analytics.index', compact(
            'dailyVisits',
            'topPages',
            'deviceBreakdown',
            'referrerStats',
            'totalVisits',
            'uniqueVisitors'
        ));
    }
}
