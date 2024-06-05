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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('job')->nullable();
            $table->string('personal_photo')->nullable();
            $table->text('personal_info')->nullable();
            $table->text('website')->nullable();
            $table->text('experience')->nullable();
            $table->string('coverletter')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('is_Active')->default(0);
           
           

            $table->string('type');
            $table->string('logo')->nullable();
            $table->text('slogo')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();

            $table->string('password');

            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
