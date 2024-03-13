@extends('layouts.other-app')

@section('styles')
@endsection

@section('body_class')
    login-page
@endsection

@section('content')
    <div class="register-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <p class="login-box-msg p-0 m-0">Forgot Password</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.email') }}" id="submitForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email" name="email"
                            value="{{ old('email') }}" email="true" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-2 theme-btn">Request New Password</button>
                </form>
                <small class="m-0 text-mode d-block"><a href="{{ route('login') }}" class="text-theme">Login</a></small>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.card -->
    </div>
@endsection

@section('scripts')
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
