@extends('layouts.other-app')

@section('styles')
<!-- icheck bootstrap -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('body_class')
register-page
@endsection

@section('content')
    <div class="register-box">
        <div class="card card-outline my-4 card-primary">
            <div class="card-header text-center">
                <p class="login-box-msg p-0 m-0">Register a new account</p>
                <p class="login-box-msg p-0 mt-2">
                    <font class="fas fa-lock"></font> End-to-end encypted
                </p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="submitForm">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Full Name" noSpace="true" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="Email" email="true" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                placeholder="password" email="true" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree"
                                {{ old('terms') ? 'checked' : '' }} required>
                            <label for="agreeTerms" class="text-mode">
                                I agree to the terms above.
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-2 theme-btn">Register</button>
                </form>
                <small class="m-0 text-mode">already have an account? <a href="{{ route('login') }}"
                        class="text-theme">Login</a></small>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.card -->
    </div>
@endsection



@section('scripts')
@endsection
