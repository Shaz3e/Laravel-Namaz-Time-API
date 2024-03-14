<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'sunrise',
        'fajr_azan',
        'fajr',
        'zuhr_azan',
        'zuhr',
        'asr_azan',
        'asr',
        'maghrib_azan',
        'maghrib',
        'isha_azan',
        'isha',
        'first_jumma_khutba',
        'first_jumma',
        'second_jumma_khutba',
        'second_jumma',
    ];
}
