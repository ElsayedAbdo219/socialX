<?php

use App\Models\News;
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
        Schema::create('poll_news', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(News::class)->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('members')->onDelete('cascade');
            $table->boolean('yes')->default(0);
            $table->boolean('no')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_news');
    }
};
