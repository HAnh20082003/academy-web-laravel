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
                            <h3>Forgot password</h3>
                            {{-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur
                            adipisicing.</p> --}}
                        </div>
                        <form action="{{ route('password.email') }}" method="post" onsubmit="return validateForm()">
                            @csrf <!-- Bắt buộc để tránh lỗi 419 -->
                            <div class="form-group first {{ old('email') ? 'field--not-empty' : '' }}">
                                <label for="email">Email</label>
                                <input type="email" value="{{ old('email') }}" class="form-control input-smaller"
                                    id="email" name="email">
                            </div>

                            <input type="submit" value="Send OTP" class="btn text-white btn-block btn-primary">
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function validateForm() {
            const email = document.getElementById('email');

            const val_email = email.value.trim();

            email.classList.remove('is-invalid');

            if (!val_email) {
                email.classList.add('is-invalid');
                toastr.clear();
                toastr.warning('Please enter your email.', 'Warning');
                email.focus();
                return false;
            }

            return true;
        }
    </script>

@endsection
