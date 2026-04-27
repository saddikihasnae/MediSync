<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('clinic_settings')->insert([
            ['key' => 'clinic_name', 'value' => 'MediSync Central Clinic'],
            ['key' => 'clinic_phone', 'value' => '+212 600 000 000'],
            ['key' => 'clinic_address', 'value' => 'Street 123, Casablanca, Morocco'],
            ['key' => 'working_hours_from', 'value' => '09:00'],
            ['key' => 'working_hours_to', 'value' => '18:00'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_settings');
    }
};
