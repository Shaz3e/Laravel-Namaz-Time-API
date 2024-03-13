<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    // View
    protected $view = 'admin.staff.';

    // Route
    protected $route = 'admin/staff';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->status != null) {
            Admin::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => 'Status has been changed'
            ]);
        }

        $dataSet = Admin::all();
        return view($this->view . 'index', compact('dataSet'));
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
        // Create validation and geneate respective message
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|max:255|email|unique:admins',
                'password' => 'required|max:64',
                'is_active' => 'required|boolean',
            ],
            [
                'name.required' => 'Name is required',
                'name.max' => 'Name is too long',

                'email.required' => 'Email is required',
                'email.max' => 'Email is too long',
                'email.email' => 'Email is invalid',
                'email.unique' => 'Email is already exists',

                'password.required' => 'Password is required',
                'password.max' => 'Password is too long',

                'is_active.required' => 'Status is required',
                'is_active.boolean' => 'Invalid status selected',
            ],
        );

        // Validate data
        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first()
            ]);
            return redirect()->back()->withInput();
        }

        // Add Record to Admin table
        $data = new Admin();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->is_active = $request->is_active;

        // Save Data to Admin Table
        $data->save();

        // Return to route and show session flash message
        return redirect($this->route)->with('message', [
            'text' => 'Staff has been added',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Admin::find($id);
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
        $data = Admin::find($id);
        if ($data) {
           return view($this->view. 'edit', compact('data'));
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
        if($request->has('password')){
            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required|max:64',
                ],
                [
                    'password.required' => 'Password is required',
                    'password.max' => 'Password is too long',
                ],
            );

            if($validator->fails()){
                return back()->with('error', [
                    'text' => $validator->errors()->first()
                ]);
            }

            Admin::where('id', $id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('message', [
                'text' => 'Password has been changed',
            ]);

        }else{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255',
                    'email' => 'required|max:255|email|unique:admins,email,'.$id,
                    'is_active' => 'required|boolean',
                ],
                [
                    'name.required' => 'Name is required',
                    'name.max' => 'Name is too long',

                    'email.required' => 'Email is required',
                    'email.max' => 'Email is too long',
                    'email.email' => 'Email is invalid',
                    'email.unique' => 'Email is already exists',

                    'is_active.required' => 'Status is required',
                    'is_active.boolean' => 'Invalid status selected',
                ],
            );

            if($validator->fails()){
                return back()->with('error', [
                    'text' => $validator->errors()->first()
                ]);
            }

            Admin::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->is_active,
            ]);

            return redirect()->back()->with('message', [
                'text' => 'Staff has been updated',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Admin::where('id', $id)->exists()) {
            $result = Admin::destroy($id);

            if ($result) {
                Session::flash('message', [
                    'text' => 'Record has been deleted',
                ]);
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'Record not found',
            ]);
        }

        return redirect($this->route);
    }
}
