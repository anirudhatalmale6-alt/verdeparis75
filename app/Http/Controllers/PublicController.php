<?php

namespace App\Http\Controllers;

use App\Models\BeforeAfter;
use App\Models\ContactMessage;
use App\Models\HomepageSection;
use App\Models\VerdeMessage;
use App\Models\VerdeMessageSetting;
use App\Mail\VerdeAdminMessageMail;
use App\Mail\VerdeClientConfirmationMail;
use App\Models\LegalPage;
use App\Models\Partner;
use App\Models\Photo;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\Video;
use App\Models\PageVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class PublicController extends Controller
{
    public function home()
    {
        $sections = HomepageSection::active()->ordered()->get()->keyBy('section_key');
        $services = Service::active()->ordered()->take(6)->get();
        $projects = Project::active()->featured()->ordered()->take(6)->get();
        $testimonials = Testimonial::active()->ordered()->take(6)->get();
        $partners = Partner::active()->ordered()->get();

        $totalVisitors = Cache::remember('total_visitors', 300, function () {
            return PageVisit::distinct('ip_address')->count('ip_address');
        });
        $totalPageViews = Cache::remember('total_pageviews', 300, function () {
            return PageVisit::count();
        });
        $onlineNow = PageVisit::where('created_at', '>=', now()->subMinutes(5))->distinct('ip_address')->count('ip_address');

        return view('public.home', compact('sections', 'services', 'projects', 'testimonials', 'partners', 'totalVisitors', 'totalPageViews', 'onlineNow'));
    }

    public function services()
    {
        $services = Service::active()->ordered()->get();
        return view('public.services', compact('services'));
    }

    public function serviceShow(string $slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.service-detail', compact('service'));
    }

    public function projects()
    {
        $projects = Project::active()->ordered()->with('images')->paginate(12);
        $categories = Project::active()->whereNotNull('category')->distinct()->pluck('category');
        return view('public.projects', compact('projects', 'categories'));
    }

    public function projectShow(string $slug)
    {
        $project = Project::where('slug', $slug)->where('is_active', true)->with('images')->firstOrFail();
        return view('public.project-detail', compact('project'));
    }

    public function beforeAfter()
    {
        $items = BeforeAfter::active()->ordered()->get();
        return view('public.before-after', compact('items'));
    }

    public function gallery(Request $request)
    {
        $sort = $request->get('sort', 'recent');
        $category = $request->get('category');

        $query = Photo::active();

        if ($category) {
            $query->where('category', $category);
        }

        $query = match ($sort) {
            'views' => $query->orderByDesc('views'),
            'likes' => $query->orderByDesc('likes'),
            'featured' => $query->where('is_featured', true)->ordered(),
            default => $query->orderByDesc('created_at'),
        };

        $photos = $query->paginate(24)->appends($request->query());
        $featured = Photo::active()->featured()->orderByDesc('views')->take(3)->get();
        $categories = Photo::active()->whereNotNull('category')->distinct()->pluck('category');

        return view('public.gallery', compact('photos', 'featured', 'categories', 'sort', 'category'));
    }

    public function photoLike(Photo $photo)
    {
        $key = 'photo-like:' . request()->ip() . ':' . $photo->id;
        if (!RateLimiter::tooManyAttempts($key, 1)) {
            $photo->increment('likes');
            RateLimiter::hit($key, 86400);
        }
        return response()->json(['likes' => $photo->fresh()->likes]);
    }

    public function photoView(Photo $photo)
    {
        $photo->increment('views');
        return response()->json(['views' => $photo->views + 1]);
    }

    public function videos(Request $request)
    {
        $sort = $request->get('sort', 'recent');
        $category = $request->get('category');

        $query = Video::active();

        if ($category) {
            $query->where('category', $category);
        }

        $query = match ($sort) {
            'views' => $query->orderByDesc('views'),
            'likes' => $query->orderByDesc('likes'),
            'featured' => $query->where('is_featured', true)->ordered(),
            default => $query->orderByDesc('created_at'),
        };

        $videos = $query->paginate(12)->appends($request->query());
        $featured = Video::active()->featured()->orderByDesc('views')->take(3)->get();
        $categories = Video::active()->whereNotNull('category')->distinct()->pluck('category');

        return view('public.videos', compact('videos', 'featured', 'categories', 'sort', 'category'));
    }

    public function videoLike(Video $video)
    {
        $key = 'video-like:' . request()->ip() . ':' . $video->id;
        if (!RateLimiter::tooManyAttempts($key, 1)) {
            $video->increment('likes');
            RateLimiter::hit($key, 86400);
        }
        return response()->json(['likes' => $video->fresh()->likes]);
    }

    public function videoView(Video $video)
    {
        $video->increment('views');
        return response()->json(['views' => $video->views + 1]);
    }

    public function partners()
    {
        $partners = Partner::active()->ordered()->get();
        return view('public.partners', compact('partners'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:120',
            'email' => 'required|email|max:180',
            'phone' => 'nullable|string|max:40',
            'subject' => 'nullable|string|max:180',
            'service' => 'nullable|string|max:120',
            'message' => 'required|string|min:10|max:5000',
            'website' => 'nullable|size:0',
            'form_started_at' => 'nullable|integer',
        ]);

        // Honeypot check
        if (!empty($request->website)) {
            return back()->with('success', 'Votre message a bien ete envoye.');
        }

        // Rate limiting
        $key = 'contact-form:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Trop de messages envoyes. Veuillez reessayer plus tard.');
        }
        RateLimiter::hit($key, 3600);

        // Timing anti-spam
        $minSeconds = (int) VerdeMessageSetting::getValue('min_seconds', 3);
        if ($request->form_started_at && time() - (int) $request->form_started_at < $minSeconds) {
            return back()->with('success', 'Votre message a bien ete envoye.');
        }

        // Bad words check
        $badWords = ['casino', 'crypto', 'viagra', 'seo backlink'];
        $text = strtolower(($request->subject ?? '') . ' ' . $request->message);
        $isSpam = collect($badWords)->contains(fn($word) => str_contains($text, $word));

        $msg = VerdeMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject ?? 'Demande via le site',
            'service' => $request->service,
            'message' => $request->message,
            'source_page' => url()->previous(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 250),
            'is_spam' => $isSpam,
        ]);

        if (!$isSpam) {
            $emails = VerdeMessageSetting::redirectEmails();
            if (!empty($emails)) {
                $msg->update(['forwarded_to' => $emails]);
                foreach ($emails as $email) {
                    try {
                        Mail::to($email)->send(new VerdeAdminMessageMail($msg));
                    } catch (\Exception $e) {}
                }
            } else {
                $adminEmail = Setting::get('email');
                if ($adminEmail) {
                    try {
                        Mail::to($adminEmail)->send(new VerdeAdminMessageMail($msg));
                        $msg->update(['forwarded_to' => [$adminEmail]]);
                    } catch (\Exception $e) {}
                }
            }

            $clientCopy = VerdeMessageSetting::getValue('client_confirmation', '1');
            if (filter_var($clientCopy, FILTER_VALIDATE_BOOLEAN)) {
                try {
                    Mail::to($msg->email)->send(new VerdeClientConfirmationMail($msg));
                } catch (\Exception $e) {}
            }
        }

        return back()->with('success', 'Votre message a bien ete envoye. Nous vous repondrons rapidement.');
    }

    public function legalPage(string $slug)
    {
        $page = LegalPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.legal', compact('page'));
    }

    public function visitorStats()
    {
        $now = now();

        $onlineNow = PageVisit::where('created_at', '>=', $now->copy()->subMinutes(5))
            ->distinct('ip_address')
            ->count('ip_address');

        $visitorsToday = PageVisit::whereDate('created_at', $now->toDateString())
            ->distinct('ip_address')
            ->count('ip_address');

        $pageViewsToday = PageVisit::whereDate('created_at', $now->toDateString())->count();

        $visitorsMonth = PageVisit::where('created_at', '>=', $now->copy()->startOfMonth())
            ->distinct('ip_address')
            ->count('ip_address');

        $topPages = PageVisit::select(
                'page_url',
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as visits')
            )
            ->where('created_at', '>=', $now->copy()->subDays(7))
            ->groupBy('page_url')
            ->orderByDesc('visits')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'page' => '/' . ($p->page_url ?: ''),
                'visits' => $p->visits,
            ]);

        return response()->json([
            'online' => $onlineNow,
            'visitors_today' => $visitorsToday,
            'pageviews_today' => $pageViewsToday,
            'visitors_month' => $visitorsMonth,
            'top_pages' => $topPages,
        ]);
    }
}
