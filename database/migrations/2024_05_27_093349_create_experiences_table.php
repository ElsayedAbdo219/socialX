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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('employment_type');
            $table->string('company_name');
            $table->string('location');
            $table->string('location_type');
            $table->string('status_works');
            $table->date('start_date');
            $table->date('start_date_year');
            $table->date('end_date')->nullable();
            $table->date('end_date_year')->nullable();
            $table->text('description');
            $table->text('profile_headline');
            $table->text('skill')->nullable();
            $table->string('media')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
