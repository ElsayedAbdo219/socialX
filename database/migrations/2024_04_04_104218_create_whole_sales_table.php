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
        Schema::create('whole_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->unsignedBigInteger('goods_type_id');
            $table->bigInteger('ton_quantity')->nullable();
            $table->double('ton_quantity_price')->nullable();
            $table->string('delivery_way');
            $table->double('ton_nolon_price')->nullable();
            $table->double('deposit_money')->nullable();
            $table->string('payment_type');
            $table->double('first_amount')->nullable();
            $table->integer('duration')->nullable();
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whole_sales');
    }
};
