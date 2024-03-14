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
            'fajr_azan' => $formatTime($this->fajr_azan),
            'fajr' => $formatTime($this->fajr),
            'sunrise' => $formatTime($this->sunrise),
            'zuhr_azan' => $formatTime($this->zuhr_azan),
            'zuhr' => $formatTime($this->zuhr),
            'asr_azan' => $formatTime($this->asr_azan),
            'asr' => $formatTime($this->asr),
            'maghrib_azan' => $formatTime($this->maghrib_azan),
            'maghrib' => $formatTime($this->maghrib),
            'isha_azan' => $formatTime($this->isha_azan),
            'isha' => $formatTime($this->isha),
            'first_jumma_khutba' => $this->first_jumma_khutba ? $formatTime($this->first_jumma_khutba) : 'Not Available',
            'first_jumma' => $this->first_jumma ? $formatTime($this->first_jumma) : 'Not Available',
            'second_jumma_khutba' => $this->second_jumma_khutba ? $formatTime($this->second_jumma_khutba) : 'Not Available',
            'second_jumma' => $this->second_jumma ? $formatTime($this->second_jumma) : 'Not Available',
        ];
    }
}
