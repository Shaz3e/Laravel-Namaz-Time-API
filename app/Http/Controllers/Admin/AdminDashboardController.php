<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{
    // View
    protected $view = 'admin.';

    // Route
    protected $route = 'admin';

    public function dashboard()
    {
        return view($this->view . 'dashboard');
    }

    public function profile(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;

        $data = Admin::find($id);

        return view($this->view . 'profile.index', compact('data'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|max:255|email|unique:admins,email,' . $id,
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

        Admin::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('message', [
            'text' => 'Profile has been updated',
        ]);
    }

    /**
     * Change Password
     */
    public function updatePassword(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
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

        Admin::where('id', $id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('message', [
            'text' => 'Password has been changed',
        ]);
    }
}
