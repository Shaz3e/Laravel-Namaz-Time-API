<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // View
    protected $view = 'admin.users.';

    // Route
    protected $route = 'admin/users';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->status != null) {
            User::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => 'Status has been changed'
            ]);
        }

        $dataSet = User::all();
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
                'email' => 'required|max:255|email|unique:users',
                'password' => 'required|max:64',
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
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);

        // Save Data to Admin Table
        $data->save();

        // Return to route and show session flash message
        return redirect($this->route)->with('message', [
            'text' => 'User has been added',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);
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
        $data = User::find($id);
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
        if ($request->has('password')) {
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

            if ($validator->fails()) {
                return back()->with('error', [
                    'text' => $validator->errors()->first()
                ]);
            }

            User::where('id', $id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('message', [
                'text' => 'Password has been changed',
            ]);
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255',
                    'email' => 'required|max:255|email|unique:users,email,' . $id,
                ],
                [
                    'name.required' => 'Name is required',
                    'name.max' => 'Name is too long',

                    'email.required' => 'Email is required',
                    'email.max' => 'Email is too long',
                    'email.email' => 'Email is invalid',
                    'email.unique' => 'Email is already exists',
                ],
            );

            if ($validator->fails()) {
                return back()->with('error', [
                    'text' => $validator->errors()->first()
                ]);
            }

            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->back()->with('message', [
                'text' => 'User has been updated',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            // Get the associated invoices for the user
            $invoices = Invoice::where('user_id', $id)->get();

            // Delete the associated invoices
            foreach ($invoices as $invoice) {
                $invoice->delete();

                // Optionally, you can also delete the associated PDF files here
                // Make sure to adjust the file path as needed
                $filePath = public_path('invoice') . '/' . $invoice->pdf_file;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
            
            // Delete the user
            $user->delete();

            Session::flash('message', [
                'text' => 'Record and associated invoices have been deleted',
            ]);
        } else {
            Session::flash('danger', [
                'text' => 'Record not found',
            ]);
        }

        return redirect($this->route);
    }

    /**
     * Login as User
     */
    public function loginAs($userId)
    {
        global $request;

        // Get the user by ID
        $user = User::find($userId);

        if ($user) {
            session(['original_user_id' => $user->id]);

            Auth::login($user);

            Session::flash('message', [
                'text' => 'Logged in as ' . $user->name,
            ]);
            return redirect('/');
        } else {
            // Handle the case when the user is not found
            // You can throw an exception, redirect the user, or display an error message
            Session::flash('warning', [
                'text' => 'Unable to login as Client',
            ]);
            return redirect()->back();
        }
    }

    /**
     * Login Back to Admin
     */
    public function loginBack()
    {
        global $request;
        // Get the original user's ID from the session
        $originalUserId = session('original_user_id');

        // Get the original user by ID
        $originalUser = User::find($originalUserId);

        if ($originalUser) {
            // Log in as the original user
            Auth::login($originalUser);

            // Clear the original user's ID from the session
            session()->forget('original_user_id');

            Session::flash('message', [
                'text' => 'Logged in as ' . $originalUser->name,
            ]);

            return redirect('/admin');
        } else {
            // Handle the case when the original user is not found
            // You can throw an exception, redirect the user, or display an error message
            Session::flash('error', [
                'text' => 'Unable to login',
            ]);

            return redirect()->back();
        }
    }
}
