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
        Schema::create('sectoral_sellings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('payment_type');
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->string('payment_amout')->nullable();
            $table->unsignedBigInteger('goods_type_id');
            $table->string('unit');
            $table->bigInteger('quantity');
            $table->double('unit_price');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectoral_sellings');
    }
};
