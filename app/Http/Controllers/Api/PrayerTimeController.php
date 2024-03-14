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
        // return new PrayerTimeResource($prayerTime->whereDate('date', now())->first());
        // Get the current date
        $currentDate = now()->toDateString();

        // Get the upcoming Friday date
        $upcomingFridayDate = now()->next('Friday')->toDateString();

        // Retrieve the prayer time for the current day or the upcoming Friday
        $prayerTime = PrayerTime::whereDate('date', $currentDate)
            ->orWhere(function ($query) use ($upcomingFridayDate) {
                $query->whereDate('date', $upcomingFridayDate)
                    ->whereNotNull('first_jumma_khutba');
            })
            ->first();

        return new PrayerTimeResource($prayerTime);
    }
}
