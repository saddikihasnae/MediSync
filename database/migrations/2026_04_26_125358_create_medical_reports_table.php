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
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_id')->unique(); // e.g., REP-1042
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // Blood Test, X-Ray Scan, etc.
            $table->date('report_date');
            $table->text('result_summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
    }
};
