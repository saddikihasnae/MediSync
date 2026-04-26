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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('age');
            $table->string('blood_group')->nullable()->after('gender');
            $table->text('medical_note')->nullable()->after('blood_group');
            $table->string('status')->default('Stable')->after('medical_note'); // Stable, Under Treatment, Recovered
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'blood_group', 'medical_note', 'status']);
        });
    }
};
