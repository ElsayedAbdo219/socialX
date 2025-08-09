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
        Schema::table('ads_prices', function (Blueprint $table) {
            $table->string('resolution')->nullable()->after('price');
            $table->enum('type', ['video', 'image'])->after('resolution')->default('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads_prices', function (Blueprint $table) {
            //
        });
    }
};
