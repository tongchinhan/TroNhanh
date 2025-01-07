<div>
    @php
        if (Auth::check()) {
            $role = auth()->user()->role;
        }
    @endphp
    {{-- form login --}}
    <div class="modal fade login-register login-register-modal" id="login-register-modal" tabindex="-1" role="dialog"
        aria-labelledby="login-register-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mxw-571" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 p-0">
                    <div class="nav nav-tabs row w-100 no-gutters" id="myTab" role="tablist">
                        <a class="nav-item col-sm-4 ml-0 nav-link pr-6 py-4 pl-9 active fs-18" id="login-tab"
                            data-toggle="tab" href="#login" role="tab" aria-controls="login"
                            aria-selected="true">Đăng nhập</a>
                        <a class="nav-item col-sm-3 ml-0 nav-link py-4 px-6 fs-18" id="register-tab" data-toggle="tab"
                            href="#register" role="tab" aria-controls="register" aria-selected="false">Đăng
                            ký</a>
                        <div class="nav-item col-sm-5 ml-0 d-flex align-items-center justify-content-end">
                            <button type="button" class="close m-0 fs-23" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-4 py-sm-7 px-sm-9">
                    <div class="tab-content shadow-none p-0" id="myTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel"
                            aria-labelledby="login-tab">
                            <form class="form" id="loginForm" method="POST"
                                action="{{ route('client.login-user') }}">
                                @csrf
                                <!-- Các trường form và phần tử lỗi cho form đăng nhập -->
                                <div class="form-group mb-4">
                                    <label for="username" class="sr-only">Tên đăng nhập / Email</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                            class="form-control border-0 shadow-none fs-13 @error('email') is-invalid @enderror"
                                            id="username" name="email" value="{{ old('email') }}" required
                                            placeholder="Tên đăng nhập / Email của bạn">
                                    </div>
                                    <div id="login-email-error" class="text-danger custom-margin-l"></div>
                                    <!-- ID khác cho lỗi -->
                                </div>

                                <div class="form-group mb-4">
                                    <label for="login-password" class="sr-only">Mật khẩu</label>
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password"
                                            class="form-control border-0 shadow-none fs-13 @error('password') is-invalid @enderror"
                                            id="login-password" name="password" required placeholder="Mật khẩu">
                                        <div class="input-group-append">
                                            <span
                                                class="input-group-text bg-gray-01 border-0 text-body fs-18 toggle-password"
                                                style="cursor: pointer;">
                                                <i class="far fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="login-password-error" class="text-danger custom-margin-l"></div>
                                </div>
                                <div></div>
                                <a href="{{ route('password.request') }}" class="d-block text-right ">Quên mật khẩu?</a>
                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">Đăng nhập</button>
                                <div id="login-loading" style="display: none; text-align: center; margin-top: 10px;">
                                    <span>Đang đăng nhập...</span>
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </form>
                            <div class="divider text-center my-2">
                                <span class="px-4 bg-white lh-17 text">
                                    hoặc tiếp tục với
                                </span>
                            </div>
                            <div class="row no-gutters mx-n2">
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block facebook text-white px-0">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-5">
                                    <a href="{{ route('client.auth.google') }}"
                                        class="btn btn-lg btn-block google px-0">
                                        <img src="{{ asset('assets/images/google.png') }}" alt="Google">
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block twitter text-white px-0">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <form class="form" id="registerForm" method="POST"
                                action="{{ route('client.register-user') }}">
                                @csrf
                                <!-- Các trường form và phần tử lỗi cho form đăng ký -->
                                <div class="form-group mb-4">
                                    <label for="full-name" class="sr-only">Họ và tên</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-address-card"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                            class="form-control border-0 shadow-none fs-13 @error('name') is-invalid @enderror"
                                            id="full-name" name="name" value="{{ old('name') }}"
                                            placeholder="Họ và tên">
                                    </div>
                                    <div id="register-name-error" class="text-danger custom-margin-left"></div>
                                    <!-- Phần tử lỗi dưới input -->
                                </div>

                                <div class="form-group mb-4">
                                    <label for="username01" class="sr-only">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                            class="form-control border-0 shadow-none fs-13 @error('email') is-invalid @enderror"
                                            id="username01" name="email" value="{{ old('email') }}" required
                                            placeholder="Tên đăng nhập / Email của bạn">
                                    </div>
                                    <div id="register-email-error" class="text-danger custom-margin-left"></div>
                                    <!-- Phần tử lỗi dưới input -->
                                </div>

                                <div class="form-group mb-4">
                                    <label for="register-password" class="sr-only">Mật khẩu</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                                                <i class="far fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password"
                                            class="form-control border-0 shadow-none fs-13 @error('password') is-invalid @enderror"
                                            id="register-password" name="password" required placeholder="Mật khẩu">
                                        <div class="input-group-append">
                                            <span
                                                class="input-group-text bg-gray-01 border-0 text-body fs-18 toggle-password"
                                                style="cursor: pointer;">
                                                <i class="far fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="register-password-error" class="text-danger custom-margin-left"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block">Đăng ký</button>
                                <div id="register-loading"
                                    style="display: none; text-align: center; margin-top: 10px;">
                                    <span>Đang đăng ký...</span>
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </form>
                            <div class="divider text-center my-2">
                                <span class="px-4 bg-white lh-17 text">
                                    hoặc tiếp tục với
                                </span>
                            </div>
                            <div class="row no-gutters mx-n2">
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block facebook text-white px-0">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="{{ route('client.auth.google') }}"
                                        class="btn btn-lg btn-block google px-0">
                                        <img src="{{ asset('assets/images/google.png') }}" alt="Google">
                                    </a>
                                </div>
                                <div class="col-4 px-2 mb-4">
                                    <a href="#" class="btn btn-lg btn-block twitter text-white px-0">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-2">Bằng cách tạo tài khoản, bạn đồng ý với <a class="text-heading"
                                    href="#"><u>Các điều khoản sử dụng</u></a> và <a class="text-heading"
                                    href="#"><u>Chính sách bảo mật</u></a> của TroNhanh.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <header
        class="main-header position-absolute fixed-top m-0 navbar-dark header-sticky header-sticky-smart header-mobile-xl">
        <div class="sticky-area">
            <div class="container container-xxl">
                <div class="d-flex align-items-center">
                    <nav class="navbar navbar-expand-xl bg-transparent px-0 w-100 w-xl-auto">
                        <a class="navbar-brand mr-7" href="{{ route('client.home') }}">
                            <img src="{{ asset('assets/images/tro-moi.png') }}" alt="tro-nhanh" class="normal-logo">

                            <img src="{{ asset('assets/images/tro-moi.png') }}" alt="tro-nhanh" class="sticky-logo">
                        </a>


                        <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse"
                            data-target="#primaryMenu02" aria-controls="primaryMenu02" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="text-white fs-24"><i class="fal fa-bars" style="color: #2f1f1f;"></i></span>
                        </button>
                        <div class="collapse navbar-collapse mt-3 mt-xl-0" id="primaryMenu02">
                            <ul class="navbar-nav hover-menu main-menu px-0 mx-xl-n4">
                                <li class="nav-item py-2 py-xl-5 px-0 px-xl-4">
                                    <a class="nav-link p-0" href="{{ route('client.room-listing') }}">
                                        Danh sách trọ
                                    </a>
                                </li>

                                <li class="nav-item py-2 py-xl-5 px-0 px-xl-4">
                                    <a class="nav-link p-0" href="{{ route('client.client-list-zone') }}">
                                        Tìm quanh đây
                                    </a>
                                </li>

                                <li class="nav-item py-2 py-xl-5 px-0 px-xl-4">
                                    <a class="nav-link p-0" href="{{ route('client.client-agent') }}">
                                        Người đăng tin
                                    </a>
                                </li>

                                <li class="nav-item py-2 py-xl-5 px-0 px-xl-4">
                                    <a class="nav-link p-0" href="{{ route('client.client-blog') }}">
                                        Blog
                                    </a>
                                </li>

                                {{-- <li class="nav-item py-2 py-xl-5 px-0 px-xl-4">
                                    <a class="nav-link p-0" href="{{ route('client.package') }}">
                                        Các gói dịch vụ
                                    </a>
                                </li> --}}
                            </ul>
                            <div class="d-block d-xl-none">
                                {{-- <div class="modal fade login-register login-register-modal" id="login-register-modal"
                                    tabindex="-1" role="dialog" aria-labelledby="login-register-modal"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered mxw-571" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 p-0">
                                                <div class="nav nav-tabs row w-100 no-gutters" id="myTab"
                                                    role="tablist">
                                                    <a class="nav-item col-sm-3 ml-0 nav-link pr-6 py-4 pl-9 active fs-18"
                                                        id="login-tab" data-toggle="tab" href="#login"
                                                        role="tab" aria-controls="login"
                                                        aria-selected="true">Login</a>
                                                    <a class="nav-item  col-sm-3 ml-0 nav-link py-4 px-6 fs-18"
                                                        id="register-tab" data-toggle="tab" href="#register"
                                                        role="tab" aria-controls="register"
                                                        aria-selected="false">Register</a>
                                                    <div
                                                        class="nav-item col-sm-6 ml-0 d-flex align-items-center justify-content-end">
                                                        <button type="button" class="close m-0 fs-23"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div> --}}
                                <ul {{-- giao diện mobile --}}
                                    class="navbar-nav flex-row ml-auto align-items-center justify-content-lg-end flex-wrap py-0">

                                    <li class="nav-item">
                                        @if (Auth::check())
                                            {{-- <a class="nav-link pr-3" data-toggle="modal" href="#user-profile-modal">
                                                {{ Auth::user()->name }} <!-- Hiển thị tên người dùng -->
                                            </a> --}}
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle mr-md-2 pr-2 pl-0 pl-lg-2" href="#"
                                            id="bd-versions" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-sm dropdown-menu-end"
                                            aria-labelledby="bd-versions">
                                            <a class="dropdown-item"
                                                href="{{ route('owners.profile.dashboard') }}">Xem thông
                                                tin</a>
                                            <a class="dropdown-item" href="{{ route('client.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Đăng xuất
                                            </a>
                                        </ul>
                                    </li>

                                    <div class="row ml-auto mr-4 p-0">
                                        <!-- Icon nhắn tin (chat icon) -->
                                        <a class="d-block mr-4 position-relative text-white p-2"
                                            href="{{ Route('owners.chat-owners') }}">
                                            <i class="fal fa-comments-alt fs-large-4" style="color: #2f1f1f;"></i>
                                            <span class="badge badge-primary badge-circle badge-absolute">
                                                <livewire:unread-message-count />
                                            </span>
                                        </a>

                                        <!-- Icon yêu thích (heart icon) -->
                                        <a class="d-block ml-auto mr-4 position-relative text-white p-2"
                                            href="{{ route('owners.favorites') }}">
                                            <i class="fal fa-heart fs-large-4" style="color: #2f1f1f;"></i>
                                            <span class="badge badge-primary badge-circle badge-absolute"
                                                id="favorite-count-2">{{ $favouriteCount }}</span>
                                        </a>
                                    </div>
                                @else
                                    <a class="nav-link pr-3" data-toggle="modal" href="#login-register-modal">
                                        Đăng nhập
                                    </a>
                                    @endif
                                    </li>

                                    {{-- @if (Auth::check())
                                        @if ($role != '1')
                                            <li class="nav-item ml-auto w-100 w-sm-auto">
                                                <a class="btn btn-primary btn-lg"
                                                    href="{{ route('owners.zone-post') }}">
                                                    Cho thuê
                                                    <img src="{{ asset('assets/images/add-listing-icon.png') }}"
                                                        alt="Add listing" class="ml-1">
                                                </a>
                                            </li>
                                        @endif
                                    @endif --}}

                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="ml-auto d-none d-xl-block">
                        <ul
                            class="navbar-nav flex-row ml-auto align-items-center justify-content-lg-end flex-wrap py-2">
                            <!-- Language Dropdown (Commented Out) -->
                            <!-- User Dropdown -->
                            <li class="nav-item">
                                @if (Auth::check())
                                    <a class="nav-link dropdown-toggle mr-md-2 pr-2 pl-0 pl-lg-2" href="#"
                                        id="bd-versions" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                                        <li><a class="dropdown-item"
                                                href="{{ route('owners.profile.dashboard') }}">Xem thông
                                                tin</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('client.payment-recharge') }}">Nạp tiền</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('client.logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                            <li class="nav-item mr-auto mr-lg-6">
                                <a class="nav-link px-2 position-relative" href="{{ Route('owners.chat-owners') }}">
                                    <i class="fal fa-comments-alt fs-large-4"></i>
                                    <span class="badge badge-primary badge-circle badge-absolute">
                                        <livewire:unread-message-count />
                                    </span>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('client.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a class="nav-link pl-3 pr-2" data-toggle="modal" href="#login-register-modal">Đăng
                                nhập</a>
                            @endif
                            </li>


                            <!-- Favorites Icon -->
                            <li class="nav-item mr-auto mr-lg-6">
                                <a class="nav-link px-2 position-relative" href="{{ route('owners.favorites') }}">
                                    <i class="fal fa-heart fs-large-4"></i>
                                    <span class="badge badge-primary badge-circle badge-absolute"
                                        id="favorite-count">{{ $favouriteCount }}</span>
                                </a>
                            </li>
                            <!-- Add Room Button -->
                            {{-- @if (Auth::check() && $role != '1')
                                <li class="nav-item">
                                    <a class="btn btn-outline-light btn-lg text-white rounded-lg bg-hover-primary border-hover-primary hover-white d-none d-lg-block"
                                        href="{{ route('owners.zone-post') }}">
                                        Cho thuê
                                        <img src="{{ asset('assets/images/add-listing-icon.png') }}"
                                            alt="Add listing" class="ml-1 normal-button-icon">
                                        <img src="{{ asset('assets/images/add-listing-icon-primary.png') }}"
                                            alt="Add listing" class="ml-1 sticky-button-icon">
                                    </a>
                                    <a class="btn btn-primary btn-lg d-block d-lg-none"
                                        href="{{ route('owners.zone-post') }}">
                                        Cho thuê
                                        <img src="{{ asset('assets/images/add-listing-icon.png') }}"
                                            alt="Add listing" class="ml-1">
                                    </a>
                                </li>
                            @endif --}}
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </header>
</div>
