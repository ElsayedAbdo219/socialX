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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->string('school');
            $table->string('degree');
            $table->string('field_of_study');
            $table->string('grade');
            $table->date('start_date');
            $table->date('start_date_year');
            $table->date('end_date')->nullable();
            $table->date('end_date_year')->nullable();
            $table->text('activities')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
