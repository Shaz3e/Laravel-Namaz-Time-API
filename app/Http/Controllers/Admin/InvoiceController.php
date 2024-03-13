<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    // View
    protected $view = 'admin.invoice.';

    // Route
    protected $route = 'admin/invoice';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->status != null) {
            Invoice::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => 'Status has been changed'
            ]);
        }

        $dataSet = Invoice::select(
            'invoices.*',
            'users.name as client'
        )
            ->leftJoin('users', 'invoices.user_id', 'users.id')
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
                'invoice_number' => 'nullable|max:64',
                'pdf_file' => 'required|mimetypes:application/pdf,application/x-pdf',
            ],
            [
                'user_id.required' => 'User is required',
                'user_id.exists' => 'User does not exist',
                'invoice_number.max' => 'Invoice number must be less than 64 characters',
                'pdf_file.required' => 'Invoice file is required',
                'pdf_file.mimetypes' => 'Invoice file must be PDF',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first()
            ]);
            return redirect()->back()->withInput();
        }

        $data = new Invoice();
        $data->user_id = $request->user_id;
        $data->invoice_number = $request->invoice_number;

        // Uplaod file in invoice folder and make it unique name
        $file = $request->file('pdf_file');
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $file->move(public_path('invoice'), $fileName);
        $data->pdf_file = $fileName;

        $data->save();

        return redirect($this->route)->with('message', [
            'text' => 'Invoice has been added',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Invoice::find($id);
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
        $data = Invoice::find($id);
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
                'invoice_number' => 'nullable|max:64',
                'pdf_file' => 'required|mimetypes:application/pdf,application/x-pdf',
            ],
            [
                'user_id.required' => 'User is required',
                'user_id.exists' => 'User does not exist',
                'invoice_number.max' => 'Invoice number must be less than 64 characters',
                'pdf_file.required' => 'Invoice file is required',
                'pdf_file.mimetypes' => 'Invoice file must be PDF',
            ],
        );

        if ($validator->fails()) {
            return back()->with('error', [
                'text' => $validator->errors()->first()
            ]);
        }

        // Retrieve the existing PDF file name from the database
        $existingPdfFileName = Invoice::where('id', $id)->value('pdf_file');

        // Check if a new file is uploaded
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $extension = $file->getClientOriginalExtension();
            $fileName = $existingPdfFileName; // Keep the existing file name
            $file->move(public_path('invoice'), $fileName);
        } else {
            // No new file is uploaded, keep the existing file name
            $fileName = $existingPdfFileName;
        }

        Invoice::where('id', $id)->update([
            'user_id' => $request->user_id,
            'invoice_number' => $request->invoice_number,
            'pdf_file' => $fileName,
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
        $invoice = Invoice::find($id);

        if ($invoice) {
            // Get the file path
            $filePath = public_path('invoice') . '/' . $invoice->pdf_file;

            if (File::exists($filePath)) {
                // Delete the file
                File::delete($filePath);
            }

            // Delete the database record
            $invoice->delete();

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
