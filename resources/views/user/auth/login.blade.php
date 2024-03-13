@extends('layouts.other-app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('body_class')
    login-page
@endsection

@section('content')
    <div class="register-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <p class="login-box-msg p-0 m-0">Welcome</p>
                <p class="login-box-msg p-0 m-0">Login to Client Portal</p>
                <p class="login-box-msg p-0 mt-2">
                    <font class="fas fa-lock"></font> End-to-end encypted
                </p>
            </div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ session('message')['text'] }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" id="submitForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                            value="{{ old('email') }}" {{-- email="true" required --}} />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password"
                            value="{{ old('password') }}" {{-- required --}} />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-2 theme-btn">Login</button>
                </form>
                <div class="row">
                    {{-- <div class="col-7">
                        <small class="m-0 text-mode">don't have an account? <a href="{{ route('register') }}"
                                class="text-theme">Register</a></small>
                    </div> --}}
                    <div class="col-12">
                        <p class="text-right">
                            <small class="m-0 text-mode"><a href="{{ route('password.request') }}"
                                    class="text-theme">Forgot
                                    Password?</a></small>
                        </p>
                    </div>
                </div>
            </div>
            {{-- /.card-body --}}
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
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
    </script>
@endsection
