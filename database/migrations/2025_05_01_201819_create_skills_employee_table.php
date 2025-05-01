<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\{
    Category,
    Skill,
};
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skills_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('members')->onDelete('cascade');
            $table->foreignIdFor(Category::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Skill::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills_employee');
    }
};
