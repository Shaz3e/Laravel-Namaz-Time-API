@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Manage Staff</a></li>
                            <li class="breadcrumb-item active">Create New</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                {{-- Col Left --}}
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Change Information</h3>
                        </div>
                        <form action="{{ route('admin.profile.updateProfile') }}" method="post" id="submitForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                value="{{ old('name', $data->name) }}" maxlength="64" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                value="{{ old('email', $data->email) }}" email="true" maxlength="255" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="profile" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                {{-- /.col left --}}
                {{-- Col Right --}}
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <form action="{{ route('admin.profile.updatePassword') }}" method="post" id="changePassword">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="text" name="password" class="form-control" id="password"
                                                value="{{ old('password') }}" maxlength="64" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="changePassword" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                {{-- /.col right --}}
            </div>
            {{-- /.row --}}

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
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
        $('#changePassword').validate({
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
