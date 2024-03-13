<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    // View
    protected $view = 'user.invoice.';

    // Route
    protected $route = 'user/my-invoice';

    public function index()
    {
        $userId = Auth::user()->id;
        $dataSet = Invoice::where('user_id', $userId)->get();

        return view($this->view . 'index', compact('dataSet'));
    }
}
