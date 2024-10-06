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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('invoice_id')->unique();  // معرف الفاتورة في Fawaterk
            $table->decimal('amount', 8, 2);  // مبلغ الفاتورة
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_url');  // رابط الدفع المقدم من Fawaterk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
