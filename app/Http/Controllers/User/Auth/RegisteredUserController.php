<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Admin\RegisterEmail as AdminRegisterEmail;
use App\Mail\User\RegisterEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    // View folder name
    protected $view = "user.auth.register";

    // route name
    protected $route = "/";

    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        return view($this->view);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users'
            ],
            [
                'name.required' => 'Please enter your name',
                'name.max' => 'Please enter a valid name',
                'email.required' => 'Please enter your email',
                'email.email' => 'Please enter a valid email',
                'email.unique' => 'This email is already registered',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return back();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        /**
         * Prepare email data
         */
        // $mailData = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'url' => config('app.url'),
        // ];

        /**
         * Send email
         */
        // $adminEmail = '';
        // Mail::to($request->email)->send(new RegisterEmail($mailData));
        // Mail::to($adminEmail)->send(new AdminRegisterEmail($mailData));

        // $this->guard()->login($user);
        Auth::guard('web')->login($user);
        Session::flash('message', [
            'text' => "You are now logged in",
        ]);
        return redirect('/');
    }
}
