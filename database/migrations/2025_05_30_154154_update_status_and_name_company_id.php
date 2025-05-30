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
        Schema::table('rate_companies', function (Blueprint $table) {
          $table->renameColumn('company_id', 'member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rate_companies', function (Blueprint $table) {
            $table->renameColumn('member_id', 'company_id');
        });
    }
};
