<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('verde_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->index();
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->string('service')->nullable()->index();
            $table->longText('message');
            $table->string('source_page')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_read')->default(false)->index();
            $table->boolean('is_archived')->default(false)->index();
            $table->boolean('is_spam')->default(false)->index();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->json('forwarded_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('verde_message_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        Schema::create('verde_message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->longText('body');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verde_message_templates');
        Schema::dropIfExists('verde_message_settings');
        Schema::dropIfExists('verde_messages');
    }
};
