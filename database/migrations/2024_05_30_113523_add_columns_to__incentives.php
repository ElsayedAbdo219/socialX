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
        Schema::table('incentives', function (Blueprint $table) {

            $table->bigInteger('ton_quantity')->default(0);

            $table->double('ton_quantity_cutting')->default(0);

            $table->double('ton_quantity_price')->default(0);

            $table->double('nolon')->nullable();

            $table->string('settlement_total')->default(0);

            $table->string('total')->default(0);

            $table->string('from'); 

            $table->string('to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incentives', function (Blueprint $table) {
            //
        });
    }
};
