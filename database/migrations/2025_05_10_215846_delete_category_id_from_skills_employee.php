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
        Schema::table('skills_employee', function (Blueprint $table) {
            // dd(Schema::getColumnListing('skills_employee'));
            // dd(Schema::hasColumn('skills_employee','category_id'));
            // $table->dropForeign('skills_employee_category_id_foreign');
             $table->dropForeign('skills_employee_category_id_foreign');
             $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skills_employee', function (Blueprint $table) {
            //
        });
    }
};
