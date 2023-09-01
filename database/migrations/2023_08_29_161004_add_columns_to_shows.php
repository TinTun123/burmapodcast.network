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
        Schema::table('shows', function (Blueprint $table) {
            //
            $table->string('pod_beam')->nullable();
            $table->string('spotify')->nullable();
            $table->string('sound_cloud')->nullable();
            $table->string('apple_podcast')->nullable();
            $table->string('google_podcast')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shows', function (Blueprint $table) {
            //
        });
    }
};
