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
        Schema::create('control_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ads_id')->constrained('posts')->onDelete('cascade');
            $table->time('play_on')->default(Carbon\Carbon::now()->toTimeString())->comment('time to play ad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_ads');
    }
};
