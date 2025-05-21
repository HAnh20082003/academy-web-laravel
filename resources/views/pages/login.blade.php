@extends('layouts.authentication')
@section('title', 'Login ' . config('constants.web_name'))


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-2">
                <img src="{{ asset('img/login/theme.svg') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 contents">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h3>Login to <strong>{{ config('constants.web_name') }}</strong></h3>
                            {{-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur
                            adipisicing.</p> --}}
                        </div>
                        <form action="{{ route('login.submit') }}" method="post" onsubmit="return validateForm()">
                            @csrf <!-- Bắt buộc để tránh lỗi 419 -->
                            <div class="form-group first {{ old('username') ? 'field--not-empty' : '' }}">
                                <label for="username">Username</label>
                                <input type="text" value="{{ old('username') }}" class="form-control input-smaller"
                                    id="username" name="username">
                            </div>
                            <div class="form-group last mb-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control input-smaller" id="password" name="password">

                            </div>

                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Remember
                                        me</span>
                                    <input type="checkbox" checked="checked" name="remember" />
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto"><a href="{{ route('password.request') }}" class="forgot-pass">Forgot
                                        Password</a></span>
                            </div>

                            <input type="submit" value="Log In" class="btn text-white btn-block btn-primary">

                            <span class="d-block text-left my-4 text-muted"> or sign in with</span>

                            <div class="social-login">
                                <a href="#" class="google">
                                    <span class="icon-google mr-3"></span>
                                </a>
                                <a href="#" class="facebook">
                                    <span class="icon-facebook mr-3"></span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function validateForm() {
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            const val_username = username.value.trim();
            const val_password = password.value.trim();

            let isValid = true;

            // Reset class trước
            username.classList.remove('is-invalid');
            password.classList.remove('is-invalid');

            if (!val_username) {
                username.classList.add('is-invalid');
                isValid = false;
            }

            if (!val_password) {
                password.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                toastr.clear();
                if (!val_username && !val_password) {
                    toastr.warning('Please enter your username and password.', 'Warning');
                } else if (!val_username) {
                    toastr.warning('Please enter your username.', 'Warning');
                    username.focus();
                } else {
                    toastr.warning('Please enter your password.', 'Warning');
                    password.focus();
                }
            }

            return isValid;
        }
    </script>
@endsection
