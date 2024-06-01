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
        Schema::create('financial_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->double('drawer_balance')->default(0);
            $table->double('drawer_ton')->default(0);

            $table->double('notebook_balance')->default(0);
            $table->double('notebook_ton')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_users');
    }
};
