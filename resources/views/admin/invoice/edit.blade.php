@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.invoice.index') }}">Manage Invoices</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.invoice.index') }}" class="btn btn-flat btn-sm btn-theme"><i
                                class="fa-regular fa-eye"></i> View
                            All</a>
                    </div>
                </div>
                <form action="{{ route('admin.invoice.update', $data->id) }}" method="post" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option
                                                value="{{ $user->id }}" {{ $user->id == old('user_id', $data->user_id) ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice #</label>
                                    <input type="text" name="invoice_number" class="form-control" id="invoice_number"
                                        value="{{ old('invoice_number') }}" invoice_number="true" minlength="3"
                                        maxlength="64" />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="pdf_file">Upload Invoice</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="pdf_file" id="pdf_file" required>
                                            <label class="custom-file-label" for="pdf_file">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        // Initialize Select2 Elements
        $('#user_id').select2({
            theme: 'bootstrap4'
        });
        $(function() {
            bsCustomFileInput.init();
        });
        $('#submitForm').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
