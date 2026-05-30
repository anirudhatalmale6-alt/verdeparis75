<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->unsignedInteger('views')->default(0)->after('description');
            $table->unsignedInteger('likes')->default(0)->after('views');
            $table->boolean('is_featured')->default(false)->after('likes');
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['views', 'likes', 'is_featured']);
        });
    }
};
