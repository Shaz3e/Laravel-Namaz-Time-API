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
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->unique();
            $table->time('fajr_azan');
            $table->time('fajr');
            $table->time('sunrise');
            $table->time('zuhr_azan');
            $table->time('zuhr');
            $table->time('asr_azan');
            $table->time('asr');
            $table->time('maghrib_azan');
            $table->time('maghrib');
            $table->time('isha_azan');
            $table->time('isha');
            $table->time('first_jumma_khutba')->nullable();
            $table->time('first_jumma')->nullable();
            $table->time('second_jumma_khutba')->nullable();
            $table->time('second_jumma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('namaz_times');
    }
};
