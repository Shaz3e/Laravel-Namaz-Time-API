<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PrayerTimeController extends Controller
{
    // View
    protected $view = 'admin.prayer-times.';

    // Route
    protected $route = 'admin/prayer-times';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prayerTime = PrayerTime::all();
        return view(
            $this->view . 'index',
            compact('prayerTime')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'prayer_date' => 'required|date_format:Y-m-d|unique:prayer_times,date',
                'sunrise' => 'required',
                'fajr_azan' => 'required',
                'fajr' => 'required',
                'zuhr_azan' => 'required',
                'zuhr' => 'required',
                'asr_azan' => 'required',
                'asr' => 'required',
                'maghrib_azan' => 'required',
                'maghrib' => 'required',
                'isha_azan' => 'required',
                'isha' => 'required',
            ],
            [
                'prayer_date.unique' => 'Prayer Time for this :attribute already exists'
            ]
        );

        // Validate data
        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first()
            ]);
            return redirect()->back()->withInput();
        }

        // dd($request->all());

        $prayerTime = [
            'date' => $request->prayer_date,

            'fajr_azan' => date('H:i:s', strtotime($request->fajr_azan)),
            'fajr' => date('H:i:s', strtotime($request->fajr)),

            'sunrise' => date('H:i:s', strtotime($request->sunrise)),

            'zuhr_azan' => date('H:i:s', strtotime($request->zuhr_azan)),
            'zuhr' => date('H:i:s', strtotime($request->zuhr)),

            'asr_azan' => date('H:i:s', strtotime($request->asr_azan)),
            'asr' => date('H:i:s', strtotime($request->asr)),

            'maghrib_azan' => date('H:i:s', strtotime($request->maghrib_azan)),
            'maghrib' => date('H:i:s', strtotime($request->maghrib)),

            'isha_azan' => date('H:i:s', strtotime($request->isha_azan)),
            'isha' => date('H:i:s', strtotime($request->isha)),

            'first_jumma_khutba' => date('H:i:s', strtotime($request->first_jumma_khutba)),
            'first_jumma' => date('H:i:s', strtotime($request->first_jumma)),
            'second_jumma_khutba' => date('H:i:s', strtotime($request->second_jumma_khutba)),
            'second_jumma' => date('H:i:s', strtotime($request->second_jumma)),
        ];

        $data = new PrayerTime();
        $data->date = $prayerTime['date'];
        $data->fajr_azan = $prayerTime['fajr_azan'];
        $data->fajr = $prayerTime['fajr'];
        $data->sunrise = $prayerTime['sunrise'];
        $data->zuhr_azan = $prayerTime['zuhr_azan'];
        $data->zuhr = $prayerTime['zuhr'];
        $data->asr_azan = $prayerTime['asr_azan'];
        $data->asr = $prayerTime['asr'];
        $data->maghrib_azan = $prayerTime['maghrib_azan'];
        $data->maghrib = $prayerTime['maghrib'];
        $data->isha_azan = $prayerTime['isha_azan'];
        $data->isha = $prayerTime['isha'];

        if (!empty($request->first_jumma_khutba)) {
            $data->first_jumma_khutba = $prayerTime['first_jumma_khutba'];
        }else{
            $data->first_jumma_khutba = null;
        }

        if (!empty($request->first_jumma)) {
            $data->first_jumma = $prayerTime['first_jumma'];
        }else{
            $data->first_jumma = null;
        }

        if (!empty($request->second_jumma_khutba)) {
            $data->second_jumma_khutba = $prayerTime['second_jumma_khutba'];
        }else{
            $data->second_jumma_khutba = null;
        }

        if (!empty($request->second_jumma)) {
            $data->second_jumma = $prayerTime['second_jumma'];
        }else{
            $data->second_jumma = null;
        }

        // Save Data
        $data->save();

        // Return to route and show session flash message
        return redirect($this->route)->with('message', [
            'text' => 'Prayer Time has been added',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prayerTime = PrayerTime::find($id);

        if ($prayerTime) {
            return redirect($this->route . '/' . $id . '/edit');
        } else {
            return redirect($this->route)->with('error', [
                'text' => 'Prayer Time not found',
            ]);
        }

        return view(
            $this->view . 'show',
            compact('prayerTime')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prayerTime = PrayerTime::find($id);

        if ($prayerTime) {
            return view($this->view . 'edit', compact('prayerTime'));
        } else {
            Session::flash('error', [
                'text' => 'Prayer Time not found',
            ]);
            return redirect()->route('admin.prayer-times.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prayerTime = PrayerTime::find($id);

        if (!$prayerTime) {
            Session::flash('error', [
                'text' => 'Prayer Time not found',
            ]);
            return redirect()->route('admin.prayer-times.index');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'prayer_date' => 'required|date_format:Y-m-d|unique:prayer_times,date,' . $id,
                'sunrise' => 'required',
                'fajr_azan' => 'required',
                'fajr' => 'required',
                'zuhr_azan' => 'required',
                'zuhr' => 'required',
                'asr_azan' => 'required',
                'asr' => 'required',
                'maghrib_azan' => 'required',
                'maghrib' => 'required',
                'isha_azan' => 'required',
                'isha' => 'required',
            ],
            [
                'prayer_date.unique' => 'Prayer Time for this :attribute already exists'
            ]
        );

        // Validate data
        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first()
            ]);
            return redirect()->back()->withInput();
        }

        // dd($request->all());

        $prayerTime = [
            'date' => $request->prayer_date,

            'fajr_azan' => date('H:i:s', strtotime($request->fajr_azan)),
            'fajr' => date('H:i:s', strtotime($request->fajr)),

            'sunrise' => date('H:i:s', strtotime($request->sunrise)),

            'zuhr_azan' => date('H:i:s', strtotime($request->zuhr_azan)),
            'zuhr' => date('H:i:s', strtotime($request->zuhr)),

            'asr_azan' => date('H:i:s', strtotime($request->asr_azan)),
            'asr' => date('H:i:s', strtotime($request->asr)),

            'maghrib_azan' => date('H:i:s', strtotime($request->maghrib_azan)),
            'maghrib' => date('H:i:s', strtotime($request->maghrib)),

            'isha_azan' => date('H:i:s', strtotime($request->isha_azan)),
            'isha' => date('H:i:s', strtotime($request->isha)),

            'first_jumma_khutba' => date('H:i:s', strtotime($request->first_jumma_khutba)),
            'first_jumma' => date('H:i:s', strtotime($request->first_jumma)),
            'second_jumma_khutba' => date('H:i:s', strtotime($request->second_jumma_khutba)),
            'second_jumma' => date('H:i:s', strtotime($request->second_jumma)),
        ];

        $data = PrayerTime::find($id);
        $data->date = $prayerTime['date'];
        $data->fajr_azan = $prayerTime['fajr_azan'];
        $data->fajr = $prayerTime['fajr'];
        $data->sunrise = $prayerTime['sunrise'];
        $data->zuhr_azan = $prayerTime['zuhr_azan'];
        $data->zuhr = $prayerTime['zuhr'];
        $data->asr_azan = $prayerTime['asr_azan'];
        $data->asr = $prayerTime['asr'];
        $data->maghrib_azan = $prayerTime['maghrib_azan'];
        $data->maghrib = $prayerTime['maghrib'];
        $data->isha_azan = $prayerTime['isha_azan'];
        $data->isha = $prayerTime['isha'];

        if (!empty($request->first_jumma_khutba)) {
            $data->first_jumma_khutba = $prayerTime['first_jumma_khutba'];
        }else{
            $data->first_jumma_khutba = null;
        }

        if (!empty($request->first_jumma)) {
            $data->first_jumma = $prayerTime['first_jumma'];
        }else{
            $data->first_jumma = null;
        }

        if (!empty($request->second_jumma_khutba)) {
            $data->second_jumma_khutba = $prayerTime['second_jumma_khutba'];
        }else{
            $data->second_jumma_khutba = null;
        }

        if (!empty($request->second_jumma)) {
            $data->second_jumma = $prayerTime['second_jumma'];
        }else{
            $data->second_jumma = null;
        }

        // Save Data
        $data->save();

        // Return to route and show session flash message
        return redirect($this->route)->with('message', [
            'text' => 'Prayer Time has been update',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getPrayerId = PrayerTime::find($id);

        if ($getPrayerId) {
            $getPrayerId->delete();
            return redirect($this->route)->with('message', [
                'text' => 'Prayer Time has been deleted',
            ]);
        } else {
            return redirect($this->route)->with('error', [
                'text' => 'Prayer Time not found',
            ]);
        }
    }

    /**
     * Import Prayer Time
     */
    public function importPrayerTimes()
    {
        return view($this->view . 'import');
    }

    /**
     * 
     */
    public function importPrayerTimesPost(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        foreach ($fileContents as $line) {
            $data = str_getcsv($line);

            PrayerTime::create([
                'date'      => date('Y-m-d', strtotime($data[0])),
                'fajr_azan'      => date('H:i:s', strtotime($data[1])),
                'fajr'      => date('H:i:s', strtotime($data[2])),
                'sunrise'   => date('H:i:s', strtotime($data[3])),
                'zuhr_azan' => date('H:i:s', strtotime($data[4])),
                'zuhr'      => date('H:i:s', strtotime($data[5])),
                'asr_azan'  => date('H:i:s', strtotime($data[6])),
                'asr'       => date('H:i:s', strtotime($data[7])),
                'maghrib_azan' => date('H:i:s', strtotime($data[8])),
                'maghrib'   => date('H:i:s', strtotime($data[9])),
                'isha_azan' => date('H:i:s', strtotime($data[10])),
                'isha'      => date('H:i:s', strtotime($data[11])),
            ]);
        }
        return redirect()->back()->with('message', [
            'text' => 'CSV file imported successfully.'
        ]);
    }
}
