<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
    /**
     * Display security overview with admin logs and failed login attempts.
     */
    public function index(Request $request)
    {
        $query = AdminLog::with('user')->latest();

        // Filter by action type
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $logs = $query->paginate(15);

        // Failed login attempts (from admin_logs where action is login_failed)
        $failedLogins = AdminLog::where('action', 'login_failed')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->latest()
            ->take(20)
            ->get();

        // Summary stats
        $stats = [
            'total_actions_today' => AdminLog::whereDate('created_at', Carbon::today())->count(),
            'total_actions_week' => AdminLog::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'total_actions_month' => AdminLog::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'failed_logins_today' => AdminLog::where('action', 'login_failed')
                ->whereDate('created_at', Carbon::today())
                ->count(),
            'failed_logins_week' => AdminLog::where('action', 'login_failed')
                ->where('created_at', '>=', Carbon::now()->startOfWeek())
                ->count(),
            'unique_ips_today' => AdminLog::whereDate('created_at', Carbon::today())
                ->distinct('ip_address')
                ->count('ip_address'),
        ];

        // Distinct action types for filter dropdown
        $actionTypes = AdminLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.security.index', compact(
            'logs',
            'failedLogins',
            'stats',
            'actionTypes'
        ));
    }
}
