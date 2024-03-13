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
                'fajr' => 'required',
                'sunrise' => 'required',
                'zuhr' => 'required',
                'asr' => 'required',
                'maghrib' => 'required',
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
            'fajr' => date('H:i:s', strtotime($request->fajr)),
            'sunrise' => date('H:i:s', strtotime($request->sunrise)),
            'zuhr' => date('H:i:s', strtotime($request->zuhr)),
            'asr' => date('H:i:s', strtotime($request->asr)),
            'maghrib' => date('H:i:s', strtotime($request->maghrib)),
            'isha' => date('H:i:s', strtotime($request->isha))
        ];

        $data = new PrayerTime();
        $data->date = $prayerTime['date'];
        $data->fajr = $prayerTime['fajr'];
        $data->sunrise = $prayerTime['sunrise'];
        $data->zuhr = $prayerTime['zuhr'];
        $data->asr = $prayerTime['asr'];
        $data->maghrib = $prayerTime['maghrib'];
        $data->isha = $prayerTime['isha'];

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
                'fajr' => 'required',
                'sunrise' => 'required',
                'zuhr' => 'required',
                'asr' => 'required',
                'maghrib' => 'required',
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

        $prayerTime = [
            'date' => $request->prayer_date,
            'fajr' => date('H:i:s', strtotime($request->fajr)),
            'sunrise' => date('H:i:s', strtotime($request->sunrise)),
            'zuhr' => date('H:i:s', strtotime($request->zuhr)),
            'asr' => date('H:i:s', strtotime($request->asr)),
            'maghrib' => date('H:i:s', strtotime($request->maghrib)),
            'isha' => date('H:i:s', strtotime($request->isha))
        ];

        $data = PrayerTime::find($id);
        $data->date = $prayerTime['date'];
        $data->fajr = $prayerTime['fajr'];
        $data->sunrise = $prayerTime['sunrise'];
        $data->zuhr = $prayerTime['zuhr'];
        $data->asr = $prayerTime['asr'];
        $data->maghrib = $prayerTime['maghrib'];
        $data->isha = $prayerTime['isha'];

        // Save Data to PrayerTime Table
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
                'fajr'      => date('H:i:s', strtotime($data[1])),
                'sunrise'   => date('H:i:s', strtotime($data[2])),
                'zuhr'      => date('H:i:s', strtotime($data[3])),
                'asr'       => date('H:i:s', strtotime($data[4])),
                'maghrib'   => date('H:i:s', strtotime($data[5])),
                'isha'      => date('H:i:s', strtotime($data[6])),
            ]);
        }
        return redirect()->back()->with('message', [
            'text' => 'CSV file imported successfully.'
        ]);
    }
}
