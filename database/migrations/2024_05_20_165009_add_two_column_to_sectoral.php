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
        Schema::table('sectoral_sellings', function (Blueprint $table) {
            $table->string('delivery_way');
            $table->double('ton_nolon_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sectoral_sellings', function (Blueprint $table) {
            //
        });
    }
};
