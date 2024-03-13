<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EmailVerificationController extends Controller
{
    // public function FunctionName(): RedirectResponse
    public function verify(Request $request)
    {
        //
    }
}
