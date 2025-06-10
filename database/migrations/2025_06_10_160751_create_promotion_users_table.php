<?php

use App\Models\
{
  Promotion
};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // $finalPrice = $originalPrice * (1 - $discountPercent / 100);  // equation of discount
    public function up(): void
    {
        Schema::create('promotion_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('members')->onDelete('cascade');
            $table->foreignIdFor(Promotion::class)->constrained()->onDelete('cascade');
            $table->date('start_date')->default(Carbon::now()->format('Y-m-d'));
            $defaultEndDate = Carbon::now()->addMonths(6)->format('Y-m-d');
            $table->date('end_date')->default($defaultEndDate);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_users');
    }
};
