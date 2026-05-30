<?php

namespace App\Http\Controllers;

use App\Models\BeforeAfter;
use App\Models\ContactMessage;
use App\Models\HomepageSection;
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

    public function gallery()
    {
        $photos = Photo::active()->ordered()->paginate(24);
        $categories = Photo::active()->whereNotNull('category')->distinct()->pluck('category');
        return view('public.gallery', compact('photos', 'categories'));
    }

    public function videos()
    {
        $videos = Video::active()->ordered()->paginate(12);
        return view('public.videos', compact('videos'));
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:5000',
        ]);

        $key = 'contact-form:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Trop de messages envoyés. Veuillez réessayer plus tard.');
        }
        RateLimiter::hit($key, 3600);

        $msg = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip_address' => $request->ip(),
        ]);

        $adminEmail = Setting::get('email');
        if ($adminEmail) {
            try {
                Mail::raw(
                    "Nouveau message de contact:\n\n" .
                    "Nom: {$msg->name}\n" .
                    "Email: {$msg->email}\n" .
                    "Telephone: " . ($msg->phone ?? '—') . "\n" .
                    "Sujet: " . ($msg->subject ?? '—') . "\n\n" .
                    "Message:\n{$msg->message}",
                    function ($mail) use ($adminEmail, $msg) {
                        $mail->to($adminEmail)
                             ->subject('Nouveau message - ' . ($msg->subject ?? 'Contact'))
                             ->replyTo($msg->email, $msg->name);
                    }
                );
            } catch (\Exception $e) {
                // Email delivery failed but message is saved in database
            }
        }

        return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }

    public function legalPage(string $slug)
    {
        $page = LegalPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('public.legal', compact('page'));
    }
}
