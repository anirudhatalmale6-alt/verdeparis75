<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;

class TrackPageVisit
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin/*') && !$request->ajax() && $request->isMethod('get')) {
            $agent = $request->userAgent();
            $device = 'desktop';
            if (preg_match('/Mobile|Android|iPhone/i', $agent)) {
                $device = 'mobile';
            } elseif (preg_match('/Tablet|iPad/i', $agent)) {
                $device = 'tablet';
            }

            PageVisit::create([
                'page_url' => $request->path(),
                'page_title' => null,
                'ip_address' => $request->ip(),
                'user_agent' => substr($agent, 0, 500),
                'referer' => $request->header('referer'),
                'device_type' => $device,
            ]);
        }

        return $next($request);
    }
}
