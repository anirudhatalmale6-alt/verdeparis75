<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\ContactMessage;
use App\Models\PageVisit;
use App\Models\Photo;
use App\Models\Project;
use App\Models\Service;
use App\Models\Partner;
use App\Models\Video;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $counts = [
            'services' => Service::count(),
            'projects' => Project::count(),
            'photos' => Photo::count(),
            'videos' => Video::count(),
            'partners' => Partner::count(),
            'messages_total' => ContactMessage::count(),
            'messages_unread' => ContactMessage::unread()->count(),
            'visits_today' => PageVisit::whereDate('created_at', $now->toDateString())->count(),
            'visits_week' => PageVisit::where('created_at', '>=', $now->copy()->startOfWeek())->count(),
        ];

        $recentLogs = AdminLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $recentMessages = ContactMessage::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'counts',
            'recentLogs',
            'recentMessages'
        ));
    }
}
