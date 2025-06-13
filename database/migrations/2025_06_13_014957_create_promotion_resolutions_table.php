<?php

use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotion_resolutions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Promotion::class)->constrained()->onDelete('cascade');
            $table->json('resolution_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_resolutions');
    }
};
