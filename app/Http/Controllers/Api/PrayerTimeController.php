<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrayerTimeResource;
use App\Models\PrayerTime;
use Illuminate\Http\Request;

class PrayerTimeController extends Controller
{
    public function prayerTime()
    {
        $prayerTime = PrayerTime::orderBy('date', 'desc')->get();
        return response()->json($prayerTime);
    }

    public function todayPrayerTime(PrayerTime $prayerTime)
    {
        return new PrayerTimeResource($prayerTime->whereDate('created_at', now())->first());
    }
}
