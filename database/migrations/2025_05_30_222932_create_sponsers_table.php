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
        Schema::create('sponsers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('members')->onDelete('cascade');
            $table->string('image');
            $table->string('days_number');
            $table->decimal('price', 10, 2);
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('payment_status')->default('unpaid'); // unpaid, paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsers');
    }
};
