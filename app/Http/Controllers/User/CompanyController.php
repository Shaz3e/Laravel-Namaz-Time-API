<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    // View
    protected $view = 'user.company.';

    // Route
    protected $route = 'user/my-company';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        $userId = Auth::user()->id;
        $dataSet = Company::where('user_id', $userId)->get();

        return view($this->view . 'index', compact('dataSet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'create', );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:64',
                'server_name' => 'required|max:64',
                'logo' => 'required|max:5000|mimetypes:image/jpeg,image/png,application/pdf',
            ],
            [
                'name.required' => 'Name is required',
                'name.max' => 'Name must be less than 64 characters',
                'server_name.required' => 'Server name is required',
                'server_name.max' => 'Server name must be less than 64 characters',
                'logo.required' => 'Logo is required',
                'logo.max' => 'Logo must be less than 5 MB',
                'logo.mimetypes' => 'Logo must be JPEG, PNG, or PDF',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first()
            ]);
            return redirect()->back()->withInput();
        }

        $data = new Company();
        $data->user_id = $userId;
        $data->name = $request->name;
        $data->server_name = $request->server_name;
        // Uplaod file in invoice folder and make it unique name
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $fileName = $userId . '-' . str_slug($request->name) . '.' . $extension;
        $file->move(public_path('company_logo'), $fileName);
        $data->logo = $fileName;

        $data->save();

        return redirect($this->route)->with('message', [
            'text' => 'Company has been added',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;
        $data = Company::where('id', $id)->where('user_id', $userId)->get();
        if ($data) {
            return redirect($this->route . '/' . $id . '/edit');
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "record not found",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = Auth::user()->id;
        $data = Company::where('id', $id)->where('user_id', $userId)->first();

        if ($data) {
            return view($this->view . 'edit', compact('data'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "record not found",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:64',
                'server_name' => 'required|max:64',
                'logo' => 'required|max:5000|mimetypes:image/jpeg,image/png,application/pdf',
            ],
            [
                'name.required' => 'Name is required',
                'name.max' => 'Name must be less than 64 characters',
                'server_name.required' => 'Server name is required',
                'server_name.max' => 'Server name must be less than 64 characters',
                'logo.required' => 'Logo is required',
                'logo.max' => 'Logo must be less than 5 MB',
                'logo.mimetypes' => 'Logo must be JPEG, PNG, or PDF',
            ],
        );

        if ($validator->fails()) {
            return back()->with('error', [
                'text' => $validator->errors()->first()
            ]);
        }

        // Retrieve the existing PDF file name from the database
        $existingPdfFileName = Company::where('id', $id)->value('logo');

        // Check if a new file is uploaded
        if ($request->hasFile('logo')) {
        // Uplaod file in invoice folder and make it unique name
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $fileName = $userId . '-' . str_slug($request->name) . '.' . $extension;
        $file->move(public_path('company_logo'), $fileName);
        
        } else {
            // No new file is uploaded, keep the existing file name
            $fileName = $existingPdfFileName;
        }

        Company::where('id', $id)->update([
            'name' => $request->name,
            'server_name' => $request->server_name,
            'logo' => $fileName,
        ]);

        return redirect()->back()->with('message', [
            'text' => 'Company has been updated',
        ]);
    }
}
