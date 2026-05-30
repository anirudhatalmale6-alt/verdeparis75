<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Global Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, image, boolean, color, json
            $table->string('group')->default('general'); // general, contact, social, seo, footer
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Services
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('slug')->unique();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // Projects / Realisations
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('client_name')->nullable();
            $table->string('location')->nullable();
            $table->date('project_date')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('category')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // Project Images
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Before/After Gallery
        Schema::create('before_afters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('before_image');
            $table->string('after_image');
            $table->string('category')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Photo Gallery
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image');
            $table->string('thumbnail')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Video Gallery
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url');
            $table->string('video_type')->default('youtube'); // youtube, vimeo, mp4
            $table->string('thumbnail')->nullable();
            $table->string('category')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Partners
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Contact Messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // Legal Pages
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->boolean('is_active')->default(true);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // SEO Settings (per-page)
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_identifier')->unique();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->text('custom_head')->nullable();
            $table->timestamps();
        });

        // Page Visits (Analytics)
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('page_url');
            $table->string('page_title')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('country')->nullable();
            $table->string('device_type')->nullable(); // desktop, tablet, mobile
            $table->timestamps();
        });

        // Admin Activity Logs
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('details')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // Backups
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('type')->default('database'); // database, full
            $table->unsignedBigInteger('size')->default(0);
            $table->string('status')->default('completed'); // completed, failed, in_progress
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Homepage Sections (CMS)
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique();
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->text('extra_data')->nullable(); // JSON for flexible content
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Testimonials (bonus for landscaping site)
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_location')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $tables = [
            'testimonials', 'homepage_sections', 'backups', 'admin_logs',
            'page_visits', 'seo_settings', 'legal_pages', 'contact_messages',
            'partners', 'videos', 'photos', 'before_afters', 'project_images',
            'projects', 'services', 'settings',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
