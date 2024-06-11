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
        Schema::create('jobs_applies', function (Blueprint $table) {

            $table->id();

            $table->foreignId('member_id'); // صاحب الوظيفة

            $table->foreignId('employee_id');  // الموظف


            $table->string('job_name'); // اسم الوظيفة

            $table->string('employee_type'); // نوع الوظيفة

            $table->string('job_period'); // مدة الوظيفة

            $table->text('overview'); // لمحة عن الوظيفة
          
          
            $table->text('job_category'); // صنف الوظيفة
          
            $table->json('job_description'); // وصف الوظيفة

           $table->string('work_level'); //  مستوي الموظف

           $table->double('salary')->default(0); // وصف الوظيفة

           $table->string('salary_period'); // مدة امبلغ الوظيفة

           $table->string('experience'); // خبرة  الوظيفة

            $table->string('is_Active')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
