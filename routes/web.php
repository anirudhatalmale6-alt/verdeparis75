<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware('track.visits')->group(function () {
    Route::get('/', [PublicController::class, 'home'])->name('home');
    Route::get('/services', [PublicController::class, 'services'])->name('services');
    Route::get('/services/{slug}', [PublicController::class, 'serviceShow'])->name('services.show');
    Route::get('/realisations', [PublicController::class, 'projects'])->name('projects');
    Route::get('/realisations/{slug}', [PublicController::class, 'projectShow'])->name('projects.show');
    Route::get('/avant-apres', [PublicController::class, 'beforeAfter'])->name('before-after');
    Route::get('/galerie', [PublicController::class, 'gallery'])->name('gallery');
    Route::post('/galerie/{photo}/like', [PublicController::class, 'photoLike'])->name('gallery.like');
    Route::post('/galerie/{photo}/view', [PublicController::class, 'photoView'])->name('gallery.view');
    Route::get('/videos', [PublicController::class, 'videos'])->name('videos');
    Route::post('/videos/{video}/like', [PublicController::class, 'videoLike'])->name('videos.like');
    Route::post('/videos/{video}/view', [PublicController::class, 'videoView'])->name('videos.view');
    Route::get('/partenaires', [PublicController::class, 'partners'])->name('partners');
    Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
    Route::post('/contact', [PublicController::class, 'contactSubmit'])->name('contact.submit');
    Route::get('/page/{slug}', [PublicController::class, 'legalPage'])->name('legal');
    Route::get('/api/visitor-stats', [PublicController::class, 'visitorStats'])->name('visitor.stats');
});

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors(['email' => 'Identifiants incorrects.'])->onlyInput('email');
})->middleware(['guest', 'throttle:5,1']);

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

// Admin routes
require __DIR__ . '/admin.php';
