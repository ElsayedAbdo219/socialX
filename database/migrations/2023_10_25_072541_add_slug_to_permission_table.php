<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('slug')->after('name')->unique()->nullable();
        });

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->string('slug')->after('name')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');
        if (Schema::hasColumn('permissions', 'slug')) {
            Schema::table($tableNames['permissions'], function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
        if (Schema::hasColumn('roles', 'slug')) {
            Schema::table($tableNames['roles'], function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
