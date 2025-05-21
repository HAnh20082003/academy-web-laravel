<style>
    .navbar-dark .nav-link:hover,
    .navbar-dark .nav-link.active {
        color: #ffc107;
        /* Vàng đẹp, dễ thấy */
    }

    .navbar-nav .nav-item {
        margin-right: 2px;
        /* Thêm khoảng cách giữa các mục */
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">

    <div class="container-fluid">
        <!-- Logo + Tên website bên trái -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="40" height="40"
                class="d-inline-block align-text-top me-2">
            {{ config('constants.web_name') }}
        </a>

        <!-- Nút toggle trên mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu bên phải -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <!-- Home / Giới thiệu / Dịch vụ -->
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                    {{-- <a class="nav-link" href="{{ route('home') }}">Home</a> --}}
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Giới thiệu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Dịch vụ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Dịch vụ 1</a></li>
                        <li><a class="dropdown-item" href="#">Dịch vụ 2</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Dịch vụ khác</a></li>
                    </ul>
                </li>

                <!-- Nếu chưa đăng nhập -->
                {{-- 
                <li class="nav-item">
                    <a class="nav-link" href="#">Đăng nhập</a>
                </li> 
                --}}

                <!-- Nếu đã đăng nhập -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                        data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=Nguyen+Hoang+Anh&background=random" alt="Avatar"
                            class="rounded-circle me-2" width="30" height="30">
                        Xin chào Anh
                        {{-- <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                            alt="Avatar" class="rounded-circle me-2" width="30" height="30">
                        Xin chào {{ Auth::user()->name }} --}}

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-person me-2"></i> Tài khoản
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
