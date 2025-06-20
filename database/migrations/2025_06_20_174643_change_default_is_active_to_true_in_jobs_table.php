<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jobs_applies', function (Blueprint $table) {
            $table->boolean('is_Active')->default(true)->change();
        });
    }

    public function down()
    {
        Schema::table('jobs_applies', function (Blueprint $table) {
            $table->boolean('is_Active')->default(false)->change();
        });
    }
};
