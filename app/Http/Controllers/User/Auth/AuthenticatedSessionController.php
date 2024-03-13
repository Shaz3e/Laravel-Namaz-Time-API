<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('user.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Email is invalid',
                'email.max' => 'Email must be less then 255 characters',

                'password.required' => 'Email is required',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $EmailExist = User::where('email', $request->email)->exists();
            if (!$EmailExist) {
                Session::flash('error', [
                    'text' => "Invalid Credentials",
                ]);
                return redirect()->back();
            } else {
                $UserPassword = User::where('email', $request->email)->value('password');

                if (Hash::check($request->password, $UserPassword)) {
                    $User = User::where('email', $request->email)->first();
                    session(['LoggedInId' => $User->id]);
                    Auth::guard('web')->login($User);
                    Session::flash('message', [
                        'text' => "Login Successfully",
                    ]);
                    return redirect('/');
                } else {
                    /** 
                     * Check incorrect password
                     */
                    Session::flash('error', [
                        'text' => "Invalid Credentials",
                    ]);
                    return redirect()->back();
                }
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
