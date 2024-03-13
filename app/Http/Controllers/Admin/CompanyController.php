<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    // View
    protected $view = 'admin.company.';

    // Route
    protected $route = 'admin/company';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->status != null) {
            Company::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => 'Status has been changed'
            ]);
        }

        $dataSet = Company::select(
            'companies.*',
            'users.name as client'
        )
            ->leftJoin('users', 'companies.user_id', 'users.id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view($this->view . 'index', compact('dataSet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        return view($this->view . 'create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'name' => 'required|max:64',
                'server_name' => 'required|max:64',
                'logo' => 'required|max:5000|mimetypes:image/jpeg,image/png,application/pdf',
            ],
            [
                'user_id.required' => 'User is required',
                'user_id.exists' => 'User not found',
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
        $data->user_id = $request->user_id;
        $data->name = $request->name;
        $data->server_name = $request->server_name;
        // Uplaod file in invoice folder and make it unique name
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $fileName = $request->user_id . '-' . str_slug($request->name) . '.' . $extension;
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
        $data = Company::find($id);
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
        $users = User::all();
        $data = Company::find($id);
        if ($data) {
            return view($this->view . 'edit', compact('data', 'users'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'name' => 'required|max:64',
                'server_name' => 'required|max:64',
                'logo' => 'required|max:5000|mimetypes:image/jpeg,image/png,application/pdf',
            ],
            [
                'user_id.required' => 'User is required',
                'user_id.exists' => 'User not found',
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
        $fileName = $request->user_id . '-' . str_slug($request->name) . '.' . $extension;
        $file->move(public_path('company_logo'), $fileName);
        
        } else {
            // No new file is uploaded, keep the existing file name
            $fileName = $existingPdfFileName;
        }

        Company::where('id', $id)->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'server_name' => $request->server_name,
            'logo' => $fileName,
        ]);

        return redirect()->back()->with('message', [
            'text' => 'Invoice has been updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);

        if ($company) {
            // Get the file path
            $filePath = public_path('company_logo') . '/' . $company->logo;

            if (File::exists($filePath)) {
                // Delete the file
                File::delete($filePath);
            }

            // Delete the database record
            $company->delete();

            Session::flash('message', [
                'text' => 'Record and associated file have been deleted',
            ]);
        } else {
            Session::flash('danger', [
                'text' => 'Record not found',
            ]);
        }

        return redirect($this->route);
    }
}
