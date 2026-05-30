<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->string('link_tiktok')->nullable();
            $table->string('link_ig')->nullable();
            $table->string('link_fb')->nullable();
            $table->dropColumn('social_media_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn(['link_tiktok', 'link_ig', 'link_fb']);
            $table->string('social_media_link')->nullable();
        });
    }
};
