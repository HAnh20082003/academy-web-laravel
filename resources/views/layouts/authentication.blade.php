<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('login-form-08/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('login-form-08/css/owl.carousel.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('login-form-08/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('login-form-08/css/style.css') }}">

    <title>@yield('title', default: 'Authentication')</title>
    <style>
        /* Viền đỏ cho input bị lỗi */
        input.is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
    <style>
        .input-smaller {
            font-size: 16px !important;
            padding: 6px 10px;
        }
    </style>

</head>

<body>



    <div class="content">
        @yield('content')
    </div>


    <script src="{{ asset('login-form-08/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('login-form-08/js/popper.min.js') }}"></script>
    <script src="{{ asset('login-form-08/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('login-form-08/js/main.js') }}"></script>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            let errorMsg = {!! json_encode(session('error')) !!};
            if (Array.isArray(errorMsg)) {
                errorMsg = errorMsg.join('<br>'); // nối các lỗi bằng thẻ <br>
            }
            toastr.error(errorMsg, null, {
                timeOut: 5000,
                extendedTimeOut: 2000,
                closeButton: true,
                escapeHtml: false
            });
        </script>
    @endif


    @if (session()->has('user_login'))
        <script>
            // Nếu người dùng đã login, nhưng quay về trang login bằng back, thì tự động chuyển trang
            window.location.href = "{{ route('admin.users.index') }}";
        </script>
    @endif



</body>

</html>
