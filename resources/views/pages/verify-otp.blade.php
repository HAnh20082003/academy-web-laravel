@extends('layouts.authentication')
@section('title', 'Forgot password ' . config('constants.web_name'))


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
                            <h3>Verify OTP</h3>
                            <p class="mb-4">Check your mail to verify OTP</p>
                        </div>
                        <form action="{{ route('password.verify') }}" method="post" onsubmit="return validateForm()">
                            @csrf <!-- Bắt buộc để tránh lỗi 419 -->
                            <input type="hidden" name="email" value="{{ request('email') }}">
                            <div class="form-group first {{ old('otp') ? 'field--not-empty' : '' }}">
                                <label for="otp">OTP</label>
                                <input type="text" value="{{ old('otp') }}" class="form-control input-smaller"
                                    id="otp" name="otp">
                            </div>
                            <div class="form-group last mb-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control input-smaller" id="password" name="password">

                            </div>
                            <div class="form-group last mb-4">
                                <label for="password-confirm">Confirm password</label>
                                <input type="password" class="form-control input-smaller" id="password-confirm"
                                    name="password-confirm">

                            </div>
                            <input type="submit" value="Reset Password" class="btn text-white btn-block btn-primary">
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function validateForm() {
            const otp = document.getElementById('otp');
            const password = document.getElementById('password');
            const password_confirm = document.getElementById('password-confirm');

            const val_otp = otp.value.trim();
            const val_password = password.value.trim();
            const val_password_confirm = password_confirm.value.trim();

            let isValid = true;

            // Reset class trước
            otp.classList.remove('is-invalid');
            password.classList.remove('is-invalid');
            password_confirm.classList.remove('is-invalid');

            if (!val_otp) {
                otp.classList.add('is-invalid');
                isValid = false;
            }

            if (!val_password) {
                password.classList.add('is-invalid');
                isValid = false;
            }
            if (!val_password_confirm) {
                password_confirm.classList.add('is-invalid');
                isValid = false;
            } else if (val_password !== val_password_confirm) {
                password_confirm.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                toastr.clear();
                if (!val_otp && !val_password && !val_password_confirm) {
                    toastr.warning('Please fill in completely.', 'Warning');
                } else if (!val_otp) {
                    toastr.warning('Please enter OTP.', 'Warning');
                    otp.focus();
                } else if (!val_password) {
                    toastr.warning('Please enter your new password.', 'Warning');
                    password.focus();
                } else if (val_password !== val_password_confirm) {
                    toastr.warning('The passwords do not match.', 'Warning');
                    password_confirm.focus();
                } else {
                    toastr.warning('Please confirm your password.', 'Warning');
                    password_confirm.focus();
                }
            }

            return isValid;
        }
    </script>

@endsection
