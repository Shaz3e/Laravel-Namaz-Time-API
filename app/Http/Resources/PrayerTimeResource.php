<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrayerTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Function to formate date from "YYYY-MM-DD" to Day, Month Date, Year
        $formatDate = function ($date) {
            return date('l, F j, Y', strtotime($date));
        };

        // Function to format time from "HH:MM:SS" to "H:MM AM/PM"
        $formatTime = function ($time) {
            return date('g:i A', strtotime($time));
        };

        // return parent::toArray($request);
        return [
            'date' => $formatDate($this->date),
            'fajr' => $formatTime($this->fajr),
            'sunrise' => $formatTime($this->sunrise),
            'zuhr' => $formatTime($this->zuhr),
            'asr' => $formatTime($this->asr),
            'maghrib' => $formatTime($this->maghrib),
            'isha' => $formatTime($this->isha)
        ];
    }
}
