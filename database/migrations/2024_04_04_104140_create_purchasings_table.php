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
        Schema::create('purchasings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('goods_type_id')->nullable();
            $table->bigInteger('ton_quantity')->nullable();
            $table->double('ton_quantity_cutting')->nullable();
            $table->double('ton_quantity_price')->nullable();
            $table->string('delivery_way')->nullable();
            $table->double('ton_colon_price')->nullable();
            $table->double('deposit_money')->nullable();
            $table->string('payment_way');
            $table->string('total');
            $table->double('first_amount')->nullable();
            $table->integer('duration')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasings');
    }
};
