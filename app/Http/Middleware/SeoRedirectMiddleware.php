<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SeoRedirect;

class SeoRedirectMiddleware
{
    public function handle($request, Closure $next)
    {
        $path = '/' . trim($request->path(), '/');
        $redirect = SeoRedirect::where('source_path', $path)->where('is_active', true)->first();

        if ($redirect) {
            return redirect($redirect->target_url, $redirect->status_code);
        }

        return $next($request);
    }
}
