@extends('layouts.main')
@section('titleUs', $zone->name . ' | TRỌ NHANH')
@section('contentUs')
    <main id="content">
        <section class="bg-secondary py-6 py-lg-0">
            <div class="container">
                <form action="{{ route('client.room-listing') }}" method="GET" class="search-form d-none d-lg-block">
                    <div class="row align-items-center">
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <label
                                        class="text-uppercase font-weight-500 opacity-7 text-white letter-spacing-093 mb-1">Loại
                                        Nhà</label>
                                    <select
                                        class="form-control selectpicker bg-transparent border-bottom rounded-0 border-input-opacity-02"
                                        name="category" title="Lựa chọn" data-style="p-0 h-24 lh-17 text-white">
                                        <option>Chung cư</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 pl-md-3 pt-md-0 pt-6">
                                    <label
                                        class="text-uppercase font-weight-500 opacity-7 text-white letter-spacing-093 mb-1">Vị
                                        Trí</label>
                                    <select
                                        class="form-control selectpicker bg-transparent border-bottom rounded-0 border-input-opacity-02"
                                        name="province" id="city-province" title="Lựa chọn"
                                        data-style="p-0 h-24 lh-17 text-white">
                                        <option value='0'>Chọn Tỉnh/Thành Phố...</option>
                                        @foreach ([
            '01' => 'Thành phố Hà Nội',
            '79' => 'Thành phố Hồ Chí Minh',
            '31' => 'Thành phố Hải Phòng',
            '48' => 'Thành phố Đà Nẵng',
            '92' => 'Thành phố Cần Thơ',
            '02' => 'Tỉnh Hà Giang',
            '04' => 'Tỉnh Cao Bằng',
            '06' => 'Tỉnh Bắc Kạn',
            '08' => 'Tỉnh Tuyên Quang',
            '10' => 'Tỉnh Lào Cai',
            '11' => 'Tỉnh Điện Biên',
            '12' => 'Tỉnh Lai Châu',
            '14' => 'Tỉnh Sơn La',
            '15' => 'Tỉnh Yên Bái',
            '17' => 'Tỉnh Hoà Bình',
            '19' => 'Tỉnh Thái Nguyên',
            '20' => 'Tỉnh Lạng Sơn',
            '22' => 'Tỉnh Quảng Ninh',
            '24' => 'Tỉnh Bắc Giang',
            '25' => 'Tỉnh Phú Thọ',
            '26' => 'Tỉnh Vĩnh Phúc',
            '27' => 'Tỉnh Bắc Ninh',
            '30' => 'Tỉnh Hải Dương',
            '33' => 'Tỉnh Hưng Yên',
            '34' => 'Tỉnh Thái Bình',
            '35' => 'Tỉnh Hà Nam',
            '36' => 'Tỉnh Nam Định',
            '37' => 'Tỉnh Ninh Bình',
            '38' => 'Tỉnh Thanh Hóa',
            '40' => 'Tỉnh Nghệ An',
            '42' => 'Tỉnh Hà Tĩnh',
            '44' => 'Tỉnh Quảng Bình',
            '45' => 'Tỉnh Quảng Trị',
            '46' => 'Tỉnh Thừa Thiên Huế',
            '49' => 'Tỉnh Quảng Nam',
            '51' => 'Tỉnh Quảng Ngãi',
            '52' => 'Tỉnh Bình Định',
            '54' => 'Tỉnh Phú Yên',
            '56' => 'Tỉnh Khánh Hòa',
            '58' => 'Tỉnh Ninh Thuận',
            '60' => 'Tỉnh Bình Thuận',
            '62' => 'Tỉnh Kon Tum',
            '64' => 'Tỉnh Gia Lai',
            '66' => 'Tỉnh Đắk Lắk',
            '67' => 'Tỉnh Đắk Nông',
            '68' => 'Tỉnh Lâm Đồng',
            '70' => 'Tỉnh Bình Phước',
            '72' => 'Tỉnh Tây Ninh',
            '74' => 'Tỉnh Bình Dương',
            '75' => 'Tỉnh Đồng Nai',
            '77' => 'Tỉnh Bà Rịa - Vũng Tàu',
            '80' => 'Tỉnh Long An',
            '82' => 'Tỉnh Tiền Giang',
            '83' => 'Tỉnh Bến Tre',
            '84' => 'Tỉnh Trà Vinh',
            '86' => 'Tỉnh Vĩnh Long',
            '87' => 'Tỉnh Đồng Tháp',
            '89' => 'Tỉnh An Giang',
            '91' => 'Tỉnh Kiên Giang',
            '93' => 'Tỉnh Hậu Giang',
            '94' => 'Tỉnh Sóc Trăng',
            '95' => 'Tỉnh Bạc Liêu',
            '96' => 'Tỉnh Cà Mau',
        ] as $code => $name)
                                            @if (in_array($code, $provinces))
                                                <option value='{{ $code }}'
                                                    {{ $province == $code ? 'selected' : '' }}>{{ $name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5 pt-lg-0 pt-6">
                            <label class="text-uppercase font-weight-500 opacity-7 text-white letter-spacing-093">Tìm
                                kiếm</label>
                            <div class="position-relative">
                                <input type="text" name="search"
                                    class="form-control bg-transparent shadow-none border-top-0 border-right-0 border-left-0 border-bottom rounded-0 h-24 lh-17 p-0 pr-md-5 text-white placeholder-light font-weight-500 border-input-opacity-02"
                                    placeholder="Nhập địa chỉ, khu phố...">
                                <i
                                    class="far fa-search position-absolute pos-fixed-right-center pr-0 fs-18 text-white pb-2 d-none d-md-block"></i>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 pt-lg-0 pt-7">
                            <button type="submit"
                                class="btn bg-white-opacity-01 bg-white-hover-opacity-03 h-lg-100 w-100 shadow-none text-white rounded-0 fs-16 font-weight-600">
                                Tìm Kiếm
                            </button>
                        </div>
                    </div>
                </form>
                <form class="property-search property-search-mobile d-lg-none">
                    <div class="row align-items-lg-center" id="accordion-mobile">
                        <div class="col-12">
                            <div class="form-group mb-0 position-relative">
                                <a href="#advanced-search-filters-mobile"
                                    class="icon-primary btn advanced-search shadow-none pr-3 pl-0 d-flex align-items-center position-absolute pos-fixed-left-center py-0 h-100 border-right collapsed"
                                    data-toggle="collapse" data-target="#advanced-search-filters-mobile"
                                    aria-expanded="true" aria-controls="advanced-search-filters-mobile">
                                </a>
                                <input type="text"
                                    class="form-control form-control-lg border-0 shadow-none pr-9 pl-11 bg-white placeholder-muted"
                                    name="key-word" placeholder="Search...">
                                <button type="submit"
                                    class="btn position-absolute pos-fixed-right-center p-0 text-heading fs-20 px-3 shadow-none h-100 border-left bg-white">
                                    <i class="far fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="advanced-search-filters-mobile" class="col-12 pt-2 collapse"
                            data-parent="#accordion-mobile">
                            <div class="row mx-n2">
                                <div class="col-sm-6 pt-4 px-2">
                                    <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                        title="Loại Nhà" data-style="btn-lg py-2 h-52 bg-white" name="type">
                                        <option>Chung cư</option>
                                        <option>Nhà Dành Cho Một Gia Đình</option>
                                        <option>Nhà Phố</option>
                                        <option>Nhà Dành Cho Nhiều Gia Đình</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 pt-4 px-2">
                                    <select class="form-control border-0 shadow-none form-control-lg selectpicker bg-white"
                                        name="bedroom" title="Vị Trí" data-style="btn-lg py-2 h-52 bg-white">
                                        <option>An Giang</option>
                                        <option>Hà Nội</option>
                                        <option>Cần Thơ</option>
                                        <option>Tp.Hồ Chí Minh</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="bg-gray-01 py-8 py-lg-0">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-3">
                        <li class="breadcrumb-item letter-spacing-1">
                            <a href=".">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item letter-spacing-1">
                            <a href="{{ route('client.room-listing') }}">Danh sách</a>
                        </li>
                        <li class="breadcrumb-item letter-spacing-1 active">{{ $zone->name }}</li>
                    </ol>
                </nav>
            </div>
        </section>
        <div class="primary-content bg-gray-01 pb-12">
            <div class="container">
                <div class="row">
                    <article class="col-lg-8">
                        <section>
                            <div class="galleries position-relative">
                                <div class="position-absolute pos-fixed-top-right z-index-3 ml-5"
                                    style="top: 2px; right: 52px;">
                                    <ul class="list-inline pt-2 ">
                                        {{-- <li class="list-inline-item mr-2">
                                            <a href="{{ route('client.add.favourite', ['slug' => $rooms->slug]) }}"
                                                class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <i class="fas fa-heart"></i>
                                            </a>
                                        </li> --}}
                                        <li class="list-inline-item">
                                            <a href="#"
                                                class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center favorite-btn {{ $zone->isFavoritedByUser(auth()->id()) ? 'favorited' : '' }}"
                                                data-zone-slug="{{ $zone->slug }}" title="Yêu thích">
                                                <i class="fas fa-heart"></i>
                                            </a>
                                        </li>


                                        <li class="list-inline-item mr-2">
                                            <button type="button" id="share-btn"
                                                class="btn btn-white p-0 d-flex align-items-center justify-content-center w-40px h-40 text-heading bg-hover-primary hover-white rounded-circle border-0 shadow-none"
                                                title="Chia sẻ">
                                                <i class="far fa-share-alt"></i>
                                            </button>
                                        </li>

                                    </ul>
                                </div>
                                <div class="slick-slider slider-for-01 arrow-haft-inner mx-0"
                                    data-slick-options='{"slidesToShow": 1, "autoplay":false,"dots":false,"arrows":false,"asNavFor": ".slider-nav-01"}'
                                    id="large-image-slider">
                                    @if ($zone->rooms->isNotEmpty())
                                        @foreach ($zone->rooms as $room)
                                            @if (!empty($room->image))
                                                <div class="box px-0">
                                                    <div class="item item-size-3-2">
                                                        <div class="card p-0 hover-change-image">
                                                            {{-- <a href="https://drive.google.com/thumbnail?id={{ $room->image }}"
                                                                class="card-img" data-fancybox="gallery"
                                                                data-caption="{{ $room->title }}"
                                                                style="background-image:url('https://drive.google.com/thumbnail?id={{ $room->image }}')">
                                                            </a> --}}
                                                            <iframe id="large-image"
                                                                src="https://drive.google.com/file/d/{{ $room->image }}/preview"
                                                                style="width: 100%; height: 480px; border: none;"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>Không có hình ảnh nào để hiển thị.</p>
                                    @endif
                                </div>

                                <div class="slick-slider slider-nav-01 mt-2 mb-2 mx-n1 arrow-haft-inner"
                                    data-slick-options='{"slidesToShow": 5, "autoplay":false,"dots":false,"arrows":false,"asNavFor": ".slider-for-01","focusOnSelect": true,"responsive":[{"breakpoint": 768,"settings": {"slidesToShow": 4}},{"breakpoint": 576,"settings": {"slidesToShow": 2}}]}'>
                                    @if ($zone->rooms->isNotEmpty())
                                        @foreach ($zone->rooms as $room)
                                            @if (!empty($room->image))
                                                <div class="box px-1">
                                                    <div class="item item-size-3-2">
                                                        <div class="card p-0 hover-change-image">
                                                            <a href="javascript:void(0);" class="card-img"
                                                                style="background-image:url('https://drive.google.com/thumbnail?id={{ $room->image }}')"
                                                                onclick="changeImage('{{ $room->image }}')">
                                                                <!-- Thêm onclick để gọi hàm -->
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <p>Không có hình ảnh nào để hiển thị.</p>
                                    @endif
                                </div>
                        </section>
                        <section class="pb-8 px-6 pt-5 bg-white rounded-lg">
                            <h4 class="fs-22 text-heading mb-3">Mô tả</h4>
                            <p class="mb-0 lh-214">{{ $zone->description }}</p>
                        </section>
                        <section class="mt-2 pb-3 px-6 pt-5 bg-white rounded-lg">
                            <h4 class="fs-22 text-heading mb-6">Tiện ích phòng</h4>
                            <div class="row">
                                {{-- <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-price fs-32 text-primary">
                                                <use xlink:href="#icon-price"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                Diện tích</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">
                                                @if ($zone->acreage)
                                                    {{ $zone->acreage }}m²
                                                @else
                                                    Chưa có thông tin
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div> --}}
                                @if ($zone->bathrooms == 1)
                                    <div class="col-lg-3 col-sm-4 mb-6">
                                        <div class="media align-items-center">
                                            <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                                <svg class="icon icon-sofa fs-32 text-primary">
                                                    <use xlink:href="#icon-sofa"></use>
                                                </svg>
                                            </div>
                                            <div class="media-body">
                                                <h5
                                                    class="my-0 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                    Phòng tắm
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($zone->garage == 1)
                                    <div class="col-lg-3 col-sm-4 mb-6">
                                        <div class="media align-items-center">
                                            <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                                <svg class="icon icon-Garage fs-32 text-primary">
                                                    <use xlink:href="#icon-Garage"></use>
                                                </svg>
                                            </div>
                                            <div class="media-body">
                                                <h5
                                                    class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                    GARAGE</h5>
                                                {{-- <p class="mb-0 fs-13 font-weight-bold text-heading">
                                                {{ $utilities->garage ?? '1' }}</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($zone->wifi == 1)
                                    <div class="col-lg-3 col-sm-4 mb-6">
                                        <div class="media align-items-center">
                                            <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                                <svg class="icon fs-32 text-primary" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 640 512">
                                                    <path fill="currentColor"
                                                        d="M634.91 154.88C457.74-8.99 182.19-8.93 5.09 154.88c-6.66 6.16-6.79 16.59-.35 22.98l34.24 33.97c6.14 6.1 16.02 6.23 22.4.38 145.92-133.68 371.3-133.71 517.25 0 6.38 5.85 16.26 5.71 22.4-.38l34.24-33.97c6.43-6.39 6.3-16.82-.36-22.98zM320 352c-35.35 0-64 28.65-64 64s28.65 64 64 64 64-28.65 64-64-28.65-64-64-64zm202.67-83.59c-115.26-101.93-290.21-101.82-405.34 0-6.9 6.1-7.12 16.69-.57 23.15l34.44 33.99c6 5.92 15.66 6.32 22.05.8 83.95-72.57 209.74-72.41 293.49 0 6.39 5.52 16.05 5.13 22.05-.8l34.44-33.99c6.56-6.46 6.33-17.06-.56-23.15z" />
                                                </svg>
                                            </div>
                                            <div class="media-body">
                                                <h5
                                                    class="my-0 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                    Wifi
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>

                        <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                            <h4 class="fs-22 text-heading lh-15 mb-5">Đánh giá & Nhận xét</h4>
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-sm-6 mb-6 mb-sm-0">
                                            <div class="bg-gray-01 rounded-lg pt-2 px-6 pb-6">
                                                <h5 class="fs-16 lh-2 text-heading mb-6">
                                                    Đánh giá trung bình
                                                </h5>
                                                <p class="fs-40 text-heading font-weight-bold mb-6 lh-1">
                                                    {{ number_format($averageRating, 1) }} <span
                                                        class="fs-18 text-gray-light font-weight-normal">/5</span>
                                                </p>
                                                <ul class="list-inline">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li
                                                            class="list-inline-item w-46px h-46 rounded-lg d-inline-flex align-items-center justify-content-center fs-24 mb-1">
                                                            <!-- Tăng fs-18 lên fs-24 -->
                                                            @if ($i <= floor($averageRating))
                                                                <i class="fas fa-star text-warning"></i>
                                                            @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
                                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-border"></i>
                                                            @endif
                                                        </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pt-3">
                                            <h5 class="fs-16 lh-2 text-heading mb-5">
                                                Phân tích đánh giá
                                            </h5>
                                            @foreach ($ratingsDistribution as $rating => $percentage)
                                                <div class="d-flex align-items-center mx-n1">
                                                    <ul class="list-inline d-flex px-1 mb-0">
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <li
                                                                class="list-inline-item {{ $rating >= $i ? 'text-warning' : 'text-border' }} mr-1">
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                        @endfor
                                                    </ul>
                                                    <div class="d-block w-100 px-1">
                                                        <div class="progress rating-progress">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: {{ $percentage }}%"
                                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-muted px-1">{{ number_format($percentage, 0) }}%
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="mt-2 pb-2 px-6 pt-6 bg-white rounded-lg">
                            @livewire('room-review', ['slug' => $zone->slug])
                        </section>

                        <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                            <div class="card border-0">
                                <div class="card-body p-0">
                                    <h3 class="fs-16 lh-2 text-heading mb-4">Viết Đánh Giá</h3>
                                    <form id="commentForm" action="{{ route('client.danh-gia-khu-tro') }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-group mb-4 d-flex justify-content-start">
                                            <div class="rate-input">
                                                <input type="radio" id="star5" name="rating" value="5">
                                                <label for="star5" title="text" class="mb-0 mr-1 lh-1">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                                <input type="radio" id="star4" name="rating" value="4">
                                                <label for="star4" title="text" class="mb-0 mr-1 lh-1">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                                <input type="radio" id="star3" name="rating" value="3">
                                                <label for="star3" title="text" class="mb-0 mr-1 lh-1">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                                <input type="radio" id="star2" name="rating" value="2">
                                                <label for="star2" title="text" class="mb-0 mr-1 lh-1">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                                <input type="radio" id="star1" name="rating" value="1">
                                                <label for="star1" title="text" class="mb-0 mr-1 lh-1">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-6">
                                            <textarea class="form-control form-control-lg border-0" placeholder="Đánh giá của bạn" name="content"
                                                rows="5"></textarea>
                                        </div>
                                        <input type="hidden" name="zone_slug" value="{{ $zone->slug }}">
                                        <button type="submit" class="btn btn-lg btn-primary px-10">Gửi</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                        </section>
                        <section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg">
                            <h4 class="fs-22 text-heading mb-6">Vị trí</h4>
                            <p class="mb-0 p-3 bg-white shadow rounded-lg">
                                {{ $zone->address }}</p>
                            <div class="position-relative">
                                <div class="position-relative">
                                    <div id="map" style="height: 296px"></div>
                                </div>
                        </section>
                        </section>
                        @if ($similarZones->isNotEmpty())
                            <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                                <h4 class="fs-22 text-heading mb-6">Có thể bạn sẽ quan tâm </h4>
                                <div class="slick-slider"
                                    data-slick-options='{"slidesToShow": 2, "dots":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                                    @foreach ($similarZones as $similarZone)
                                        <div class="box">
                                            <div class="card shadow-hover-2 =">
                                                <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                                                    @php
                                                        $image = $similarZone->rooms->first()->image ?? null;
                                                    @endphp
                                                    <div class="image-wrapper"
                                                        style="padding-top: 66.67%; position: relative; overflow: hidden;">
                                                        @if ($image)
                                                            <img src="https://drive.google.com/thumbnail?id={{ $image }}"
                                                                alt="{{ $similarZone->title }}"
                                                                class="img-fluid rounded position-absolute"
                                                                style="top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                                loading="lazy">
                                                        @else
                                                            <img src="{{ asset('assets/images/properties-grid-01.jpg') }}"
                                                                alt="{{ $similarZone->title }}"
                                                                class="img-fluid rounded position-absolute"
                                                                style="top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                        @endif

                                                    </div>
                                                    <div class="card-img-overlay p-2 d-flex flex-column">

                                                        @if ($similarZone->expiration_date > now())
                                                            <div>
                                                                <span class="badge mr-2 badge-danger">VIP</span>
                                                            </div>
                                                        @endif
                                                        <ul class="list-inline mb-0 mt-auto hover-image">
                                                            {{-- <li class="list-inline-item mr-2" data-toggle="tooltip"
                                                                title="9 Images">
                                                                <a href="#" class="text-white hover-primary">
                                                                    <i class="far fa-images"></i><span
                                                                        class="pl-1">9</span>
                                                                </a>
                                                            </li> --}}

                                                            <li class="list-inline-item mr-2" data-toggle="tooltip"
                                                                title="{{ $similarZone->images_count }} ảnh">
                                                                <a href="#" class="text-white hover-primary">
                                                                    <i class="far fa-images"></i><span
                                                                        class="pl-1">{{ $similarZone->images_count }}</span>
                                                                </a>
                                                            </li>
                                                            {{-- <li class="list-inline-item" data-toggle="tooltip"
                                                                title="2 Video">
                                                                <a href="#" class="text-white hover-primary">
                                                                    <i class="far fa-play-circle"></i><span
                                                                        class="pl-1">2</span>
                                                                </a>
                                                            </li> --}}
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-body pt-3">
                                                    <h2 class="card-title fs-16 lh-2 mb-0"><a
                                                            href="{{ route('client.detail-zone', ['slug' => $similarZone->slug]) }}"
                                                            class="text-dark hover-primary">{{ $similarZone->name }}</a>
                                                    </h2>
                                                    <p class="card-text font-weight-500 text-gray-light mb-2">
                                                        {{ $similarZone->address }}</p>
                                                    <ul class="list-inline d-flex mb-0 flex-wrap mr-n4">

                                                        @if ($similarZone->utility && $similarZone->utility->bathrooms == 1)
                                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                                data-toggle="tooltip" title="Phòng tắm">
                                                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                                    <use xlink:href="#icon-shower"></use>
                                                                </svg>
                                                                Phòng tắm
                                                            </li>
                                                        @endif
                                                        @if ($similarZone->garage == 1)
                                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                                data-toggle="tooltip" title="Garage">
                                                                <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                                    <use xlink:href="#icon-Garage"></use>
                                                                </svg>
                                                                Ga-ra
                                                            </li>
                                                        @endif
                                                        @if ($similarZone->wifi == 1)
                                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4"
                                                                data-toggle="tooltip" title="WiFi">
                                                                <svg class="icon fs-18 text-primary mr-1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 640 512">
                                                                    <path fill="currentColor"
                                                                        d="M634.91 154.88C457.74-8.99 182.19-8.93 5.09 154.88c-6.66 6.16-6.79 16.59-.35 22.98l34.24 33.97c6.14 6.1 16.02 6.23 22.4.38 145.92-133.68 371.3-133.71 517.25 0 6.38 5.85 16.26 5.71 22.4-.38l34.24-33.97c6.43-6.39 6.3-16.82-.36-22.98zM320 352c-35.35 0-64 28.65-64 64s28.65 64 64 64 64-28.65 64-64-28.65-64-64-64zm202.67-83.59c-115.26-101.93-290.21-101.82-405.34 0-6.9 6.1-7.12 16.69-.57 23.15l34.44 33.99c6 5.92 15.66 6.32 22.05.8 83.95-72.57 209.74-72.41 293.49 0 6.39 5.52 16.05 5.13 22.05-.8l34.44-33.99c6.56-6.46 6.33-17.06-.56-23.15z" />
                                                                </svg>
                                                                WiFi
                                                            </li>
                                                        @endif
                                                        {{-- @if ($rooms->utility && $rooms->utility->bathrooms == 1)
                                                            <div class="col-6 mb-3">
                                                                <div class="media align-items-center">
                                                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                                                        <svg class="icon icon-shower fs-18 text-primary">
                                                                            <use xlink:href="#icon-shower"></use>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h5 class="fs-13 font-weight-normal mb-0">Phòng tắm
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mb-3">
                                                            <div class="media">
                                                                <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                                                    <svg class="icon icon-square fs-18 text-primary">
                                                                        <use xlink:href="#icon-square"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h5 class="fs-13 font-weight-normal mb-0">Diện tích
                                                                    </h5>
                                                                    <p class="mb-0 fs-13 font-weight-bold text-dark">
                                                                        @if ($rooms->acreage)
                                                                            {{ $rooms->acreage }}m²
                                                                        @else
                                                                            Chưa có thông tin
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($rooms->utility && $rooms->utility->garage == 1)
                                                            <div class="col-6 mb-3">
                                                                <div class="media align-items-center">
                                                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                                                        <svg class="icon icon-Garage fs-18 text-primary">
                                                                            <use xlink:href="#icon-Garage"></use>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h5 class="fs-13 font-weight-normal mb-0">Garage
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($rooms->utility && $rooms->utility->wifi == 1)
                                                            <div class="col-lg-3 col-sm-4 mb-6">
                                                                <div class="media align-items-center">
                                                                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                                                        <svg class="icon fs-18 text-primary"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 640 512">
                                                                            <path fill="currentColor"
                                                                                d="M634.91 154.88C457.74-8.99 182.19-8.93 5.09 154.88c-6.66 6.16-6.79 16.59-.35 22.98l34.24 33.97c6.14 6.1 16.02 6.23 22.4.38 145.92-133.68 371.3-133.71 517.25 0 6.38 5.85 16.26 5.71 22.4-.38l34.24-33.97c6.43-6.39 6.3-16.82-.36-22.98zM320 352c-35.35 0-64 28.65-64 64s28.65 64 64 64 64-28.65 64-64-28.65-64-64-64zm202.67-83.59c-115.26-101.93-290.21-101.82-405.34 0-6.9 6.1-7.12 16.69-.57 23.15l34.44 33.99c6 5.92 15.66 6.32 22.05.8 83.95-72.57 209.74-72.41 293.49 0 6.39 5.52 16.05 5.13 22.05-.8l34.44-33.99c6.56-6.46 6.33-17.06-.56-23.15z" />
                                                                        </svg>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <h5
                                                                            class="my-0 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                                            Wifi
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif --}}
                                                    </ul>
                                                </div>
                                                <div
                                                    class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                                    <p class="fs-17 font-weight-bold text-heading mb-0">
                                                        @if ($similarZone->rooms->isNotEmpty())
                                                            @php
                                                                $prices = $similarZone->rooms->pluck('price');
                                                                $minPrice = $prices->min();
                                                                $maxPrice = $prices->max();
                                                            @endphp
                                                            @if ($similarZone->rooms->count() == 1)
                                                                {{ number_format($minPrice, 0, ',', '.') }} VND
                                                            @else
                                                                {{ number_format($minPrice, 0, ',', '.') }} -
                                                                {{ number_format($maxPrice, 0, ',', '.') }} VND
                                                            @endif
                                                        @else
                                                            Giá không có sẵn
                                                        @endif
                                                    </p>
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item mr-2">
                                                            <a href="#"
                                                                class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center favorite-btn {{ $similarZone->isFavoritedByUser(auth()->id()) ? 'favorited' : '' }}"
                                                                data-zone-slug="{{ $similarZone->slug }}"
                                                                title="Yêu thích">
                                                                <i class="fas fa-heart"></i>
                                                            </a>
                                                        </li>
                                                        {{-- <li class="list-inline-item">
                                                            <a href="#"
                                                                class="w-40px h-40 border rounded-circle d-inline-flex align-items-center justify-content-center text-body hover-secondary bg-hover-accent border-hover-accent"
                                                                data-toggle="tooltip" title="Compare"><i
                                                                    class="fas fa-exchange-alt"></i></a>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    </article>
                    <aside class="col-lg-4 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar">
                        <div class="primary-sidebar-inner">
                            <div class="bg-white rounded-lg py-lg-6 pl-lg-6 pr-lg-3 p-4">
                                @if ($zone->expiration_date > now())
                                    <ul class="list-inline d-sm-flex align-items-sm-center mb-2">
                                        {{-- <li class="list-inline-item badge badge-orange mr-2">Đặc sắc</li> --}}
                                        <li class="list-inline-item badge badge-danger mr-3">VIP</li>
                                    </ul>
                                @endif
                                <h2 class="fs-22 text-heading pt-2">{{ $zone->title }}</h2>
                                <p class="mb-2"><i class="fal fa-map-marker-alt mr-1"></i>{{ $zone->address }}</p>
                                <div class="d-flex align-items-center">
                                    <p class="fs-22 text-heading font-weight-bold mb-0 mr-6">
                                        @if ($zone->rooms->isNotEmpty())
                                            @php
                                                $prices = $zone->rooms->pluck('price');
                                                $minPrice = $prices->min();
                                                $maxPrice = $prices->max();
                                            @endphp
                                            @if ($minPrice === $maxPrice)
                                                {{ number_format($minPrice, 0, ',', '.') }} VND
                                            @else
                                                {{ number_format($minPrice, 0, ',', '.') }} -
                                                {{ number_format($maxPrice, 0, ',', '.') }} VND
                                            @endif
                                        @else
                                            Giá không có sẵn
                                        @endif
                                    </p>
                                </div>
                                <div class="row mt-5">
                                    @if ($zone->utility && $zone->utility->bathrooms == 1)
                                        <div class="col-6 mb-3">
                                            <div class="media align-items-center">
                                                <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                                    <svg class="icon icon-shower fs-18 text-primary">
                                                        <use xlink:href="#icon-shower"></use>
                                                    </svg>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-13 font-weight-normal mb-0">Phòng tắm</h5>
                                                    {{-- <p class="mb-0 fs-13 font-weight-bold text-dark">
                                                    {{ $utilities->bathroom ?? '2' }}</p> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 mb-3">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="fs-13 font-weight-normal mb-3">Các loại phòng</h5>
                                                @if ($zone->rooms->isNotEmpty())
                                                    <div class="d-flex flex-wrap">
                                                        @foreach ($zone->rooms->filter(function ($room) {
            return $room->quantity > 0;
        }) as $index => $room)
                                                            <a href="javascript:void(0);" class="room-select"
                                                                data-room-title="{{ $room->title }}"
                                                                data-room-id="{{ $room->id }}"
                                                                data-room-image="{{ asset('assets/images/' . $room->image) }}"
                                                                data-available-quantity="{{ $room->quantity }}"
                                                                data-room-price="{{ $room->price }}"
                                                                onclick="changeImage('{{ $room->image }}')">
                                                                <!-- Thêm onclick để gọi hàm -->
                                                                <div
                                                                    class="p-2 shadow-xxs-1 rounded-lg mr-3 mb-3 lh-1 border">
                                                                    <p class="mb-0 fs-13 text-dark">
                                                                        {{ $room->title ?? 'Chưa có thông tin' }}
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="mb-0 fs-13 font-weight-bold text-dark">Chưa có thông tin
                                                        phòng</p>
                                                @endif
                                            </div>
                                            <script>
                                                function changeImage(imageId) {
                                                    const iframe = document.getElementById('large-image');
                                                    if (iframe) { // Kiểm tra xem iframe có tồn tại không
                                                        iframe.src = `https://drive.google.com/file/d/${imageId}/preview`; // Cập nhật src của iframe
                                                    } else {
                                                        console.error("Iframe with ID 'large-image' not found.");
                                                    }
                                                }
                                            </script>
                                            <script>
                                                function goToSlide(index, imageId) {
                                                    // Chuyển đến slide tương ứng trong slider lớn
                                                    $('#large-image-slider').slick('slickGoTo', index); // Chuyển đến slide tương ứng
                                                 // Cập nhật iframe với hình ảnh tương ứng
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog"
                                        aria-labelledby="bookingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered mxw-571" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 p-4">
                                                    <h5 class="modal-title" id="bookingModalLabel">Đặt Phòng</h5>
                                                    <button type="button" class="close fs-23" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body p-4 py-sm-7 px-sm-8 text-center">
                                                    <h2 class="text-heading mb-3 fs-22 fs-md-32 lh-1-5">Đặt Phòng Ngay!
                                                    </h2>
                                                    <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">
                                                        Vui lòng điền thông tin bên dưới để đặt phòng. Chúng tôi sẽ xác nhận
                                                        yêu cầu của bạn trong thời gian sớm nhất.
                                                    </p>
                                                    <form id="bookingForm" method="POST"
                                                        action="{{ route('client.booking', ['id' => $zone->id]) }}">
                                                        @csrf
                                                        <input type="hidden" name="zone_id"
                                                            value="{{ $zone->id }}">
                                                        <input type="hidden" name="room_id" id="room-id"
                                                            value="">
                                                        <div class="form-group mb-4">
                                                            <label for="room-quantity">Giá phòng:</label>
                                                            <span id="room-price" name="room_price" readonly></span>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="room-quantity">Số lượng:</label>
                                                            <input type="number" id="room-quantity" name="quantity"
                                                                class="form-control" min="1" value="1">
                                                        </div>
                                                        <button type="button" id="submitBooking"
                                                            class="btn btn-lg btn-primary px-5">Đặt Phòng</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($zone->utility && $zone->utility->garage == 1)
                                        <div class="col-6 mb-3">
                                            <div class="media align-items-center">
                                                <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                                    <svg class="icon icon-Garage fs-18 text-primary">
                                                        <use xlink:href="#icon-Garage"></use>
                                                    </svg>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="fs-13 font-weight-normal mb-0">Garage</h5>
                                                    {{-- <p class="mb-0 fs-13 font-weight-bold text-dark">
                                                    {{ $utilities->garage ?? '1' }}</p> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($zone->utility && $zone->utility->wifi == 1)
                                        <div class="col-lg-3 col-sm-4 mb-6">
                                            <div class="media align-items-center">
                                                <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                                    <svg class="icon fs-18 text-primary"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                                        <path fill="currentColor"
                                                            d="M634.91 154.88C457.74-8.99 182.19-8.93 5.09 154.88c-6.66 6.16-6.79 16.59-.35 22.98l34.24 33.97c6.14 6.1 16.02 6.23 22.4.38 145.92-133.68 371.3-133.71 517.25 0 6.38 5.85 16.26 5.71 22.4-.38l34.24-33.97c6.43-6.39 6.3-16.82-.36-22.98zM320 352c-35.35 0-64 28.65-64 64s28.65 64 64 64 64-28.65 64-64-28.65-64-64-64zm202.67-83.59c-115.26-101.93-290.21-101.82-405.34 0-6.9 6.1-7.12 16.69-.57 23.15l34.44 33.99c6 5.92 15.66 6.32 22.05.8 83.95-72.57 209.74-72.41 293.49 0 6.39 5.52 16.05 5.13 22.05-.8l34.44-33.99c6.56-6.46 6.33-17.06-.56-23.15z" />
                                                    </svg>
                                                </div>
                                                <div class="media-body">
                                                    <h5
                                                        class="my-0 fs-14 text-uppercase letter-spacing-093 font-weight-normal">
                                                        Wifi
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                {{-- <p class="mb-6 mt-1">{{ $rooms->description }}</p> --}}
                                <div class="mr-xl-2">
                                    <button id="book-room-btn"
                                        class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4 mb-4"
                                        style="display: none;">
                                        Đặt Phòng
                                    </button>
                                    <a href="{{ route('client.client-agent-detail', ['slug' => $user->slug]) }}"
                                        class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white">Người
                                        đăng: {{ $user->name }}</a>
                                    {{-- @auth
                                        <a data-toggle="modal" href="#report-modal"
                                            class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4">Gửi
                                            báo cáo</a>
                                    @else
                                        <a data-toggle="modal" href="#login-register-modal"
                                            class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4">Đăng
                                            nhập để gửi báo cáo</a>
                                    @endauth --}}
                                    @auth
                                        @if (auth()->id() != $zone->user_id)
                                            <a data-toggle="modal" href="#report-modal"
                                                class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4">Gửi
                                                báo cáo</a>
                                        @else
                                            <button style="display: none;"
                                                class="btn btn-outline-secondary btn-lg btn-block rounded border text-body mt-4"
                                                disabled>
                                                Không thể báo cáo chính mình
                                            </button>
                                        @endif
                                    @else
                                        <a data-toggle="modal" href="#login-register-modal"
                                            class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4">Đăng
                                            nhập để gửi báo cáo</a>
                                    @endauth
                                    <!-- <a href="#"
                                                                                                                                                                                                                                    class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4">Yêu
                                                                                                                                                                                                                                    cầu thông tin</a> -->

                                    @if ($zone)
                                        <!-- Nút để mở modal -->
                                        {{-- @if ($zones->residents->isNotEmpty())
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-lg btn-block rounded border text-body mt-4"
                                                disabled>
                                                Hết phòng
                                            </button>
                                        @else
                                            <button type="button"
                                                class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4"
                                                data-bs-toggle="modal" data-bs-target="#accountInfoModal">
                                                Tham gia khu trọ
                                            </button>
                                        @endif --}}

                                        <!-- Modal -->
                                    @endif
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
        {{-- <section>
            <div
                class="d-flex bottom-bar-action bottom-bar-action-01 py-2 px-4 bg-gray-01 align-items-center position-fixed fixed-bottom d-sm-none">
                <div class="media align-items-center">
                    <img src="images/irene-wallace.png" alt="Irene Wallace" class="mr-4 rounded-circle">
                    <div class="media-body">
                        <a href="#" class="d-block text-dark fs-15 font-weight-500 lh-15">Irene Wallace</a>
                        <span class="fs-13 lh-2">Sales Excutive</span>
                    </div>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary fs-18 p-2 lh-1 mr-1 mb-1 shadow-none"
                        data-toggle="modal" data-target="#modal-messenger"><i class="fal fa-comment"></i></button>
                    <a href="tel:(+84)2388-969-888" class="btn btn-primary fs-18 p-2 lh-1 mb-1 shadow-none"
                        target="_blank"><i class="fal fa-phone"></i></a>
                </div>
            </div>




        </section> --}}
    </main>
    <div class="modal fade report-modal" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mxw-571" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title">Gửi Báo Cáo</h5>
                    <button type="button" class="close fs-23" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 py-sm-7 px-sm-8 text-center">
                    <h2 class="text-heading mb-3 fs-22 fs-md-32 lh-1-5">
                        Gặp Vấn Đề Với Phòng Trọ? Báo Cáo Ngay!
                    </h2>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">
                        Trọ Nhanh luôn lắng nghe ý kiến của bạn. Nếu bạn gặp phải bất kỳ vấn đề nào với phòng trọ hoặc khu
                        trọ
                        của mình, hãy cho chúng tôi biết. Chúng tôi sẽ nhanh chóng xử lý để đảm bảo trải nghiệm sống tốt
                        nhất
                        cho bạn.
                    </p>
                    <form id="reportForm" method="POST" action="{{ route('client.report-store-zone') }}">
                        @csrf
                        <input type="hidden" name="zone_id" value="{{ $zone->id }}">
                        <input type="hidden" name="reported_person" value="{{ $zone->user_id }}">
                        <input type="hidden" name="status" value="1">

                        <div class="form-group mb-4">
                            <textarea class="form-control border-0 " placeholder="Nội dung báo cáo..." name="description" id="description"
                                rows="5">{{ old('description') }}</textarea>
                            <span id="description-error" class="text-danger"></span>
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary px-5">Gửi Báo Cáo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('styleUs')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Chi tiết về các phòng trọ cho thuê tại TRỌ NHANH - thông tin chính xác, đầy đủ và hữu ích cho người thuê nhà.">
    <meta name="author" content="TRỌ NHANH">
    <meta name="generator" content="TRỌ NHANH">
    {{-- <title>Chi Tiết Phòng Trọ | TRỌ NHANH</title> --}}

    <!-- Google fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome-pro-5/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-select/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/slick/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/magnific-popup/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/chartjs/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropzone/css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/timepicker/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mapbox-gl/mapbox-gl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dataTables/jquery.dataTables.min.css') }}">
    <!-- Themes core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/themes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mh.css') }}">
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-nav.png') }}" />
    <!-- Share Meta Tags -->
    @php
        $imageUrl = '';
        if ($zone->rooms->isNotEmpty() && $zone->rooms->first()->image) {
            $fileId = $zone->rooms->first()->image;
            // Sử dụng URL trực tiếp từ Google Drive
            $imageUrl = 'https://drive.google.com/uc?export=view&id=' . $fileId;
        } else {
            $imageUrl = asset('assets/images/properties-grid-04.jpg');
        }
    @endphp

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@TroNhanh">
    <meta name="twitter:creator" content="@TroNhanh">
    <meta name="twitter:title" content="{{ $zone->name }}">
    <meta name="twitter:description" content="{{ $zone->description ?? 'Thông tin chi tiết về phòng trọ.' }}">
    <meta name="twitter:image" content="{{ $imageUrl }}">
    <meta name="twitter:image:alt" content="{{ $zone->name }}">

    <!-- Facebook Open Graph Meta Tags -->
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $zone->name }}">
    <meta property="og:description" content="{{ $zone->description ?? 'Thông tin chi tiết về phòng trọ.' }}">
    <meta property="og:image" content="{{ $imageUrl }}">
    <meta property="og:image:secure_url" content="{{ $imageUrl }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Trọ Nhanh">
    <meta property="og:locale" content="vi_VN">

    <!-- Thêm thẻ meta cho rich preview -->
    <meta property="article:published_time" content="{{ $zone->created_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $zone->updated_at->toIso8601String() }}">
    <meta property="article:author" content="{{ $zone->user->name ?? 'Trọ Nhanh' }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        .leaflet-control-directions {
            background-color: #fff;
            border-radius: 40px;
            padding: 10px 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 14px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .leaflet-control-directions:hover {
            background-color: #f8f8f8;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .leaflet-control-directions i {
            margin-right: 8px;
            font-size: 16px;
        }

        .leaflet-control-directions span {
            white-space: nowrap;
        }

        .room-select .border {
            transition: background-color 0.3s, color 0.3s;
        }

        .room-select .border:hover {
            background-color: primary;
            /* Màu nền khi hover */
            color: #fff;
            /* Màu chữ khi hover */
        }

        .room-select .border.bg-primary.text-white {
            color: #fff !important;
            /* Màu chữ khi được chọn */
        }
    </style>
@endpush
@push('scriptUs')
    <!-- Vendors scripts -->
    <script src="{{ asset('assets/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/counter/countUp.js') }}"></script>
    <script src="{{ asset('assets/vendors/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/dropzone/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/hc-sticky/hc-sticky.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jparallax/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/mapbox-gl/mapbox-gl.js') }}"></script>
    <script src="{{ asset('assets/vendors/dataTables/jquery.dataTables.min.js') }}"></script>
    <!-- Theme scripts -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/comment.js') }}"></script>
    <script src="{{ asset('assets/js/register-zone.js') }}"></script>
    <script src="{{ asset('assets/js/yeuthich.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="{{ asset('assets/js/alert-update-user.js') }}"></script>
    <script src="{{ asset('assets/js/alert-report.js') }}"></script>

    <script>
        var userIsLoggedIn = @json(auth()->check());
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        window.successMessage = "{{ session('success') }}";
        window.errorMessage = "{{ session('error') }}";
    </script>
    {{-- <script>
        Fancybox.bind("[data-fancybox='gallery']", {
            // Các tùy chọn tùy chỉnh cho Fancybox
        });
    </script>
    <script src="{{ asset('assets/js/alert-update-user.js') }}"></script>
    <script src="{{ asset('assets/js/alert-report.js') }}"></script> --}}

    <script>
        Fancybox.bind("[data-fancybox='gallery']", {
            // Các tùy chọn tùy chỉnh cho Fancybox
        });
    </script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var latitude = {{ $zone->latitude }};
            var longitude = {{ $zone->longitude }};
            var zoneName = "{{ $zone->name }}";

            var map = L.map('map').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var customIcon = L.icon({
                iconUrl: '{{ asset('assets/images/341144.png') }}',
                iconSize: [30, 30],
                iconAnchor: [22, 38],
                popupAnchor: [-3, -38]
            });

            L.marker([latitude, longitude], {
                    icon: customIcon
                }).addTo(map)
                .bindPopup(zoneName)
                .openPopup();

            var directionsButton = L.control({
                position: 'topright'
            });

            directionsButton.onAdd = function(map) {
                var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                div.innerHTML =
                    '<a href="#" title="Chỉ đường" aria-label="Chỉ đường" role="button"><i class="fas fa-directions "></i></a>';
                div.onclick = function() {
                    var url = 'https://www.google.com/maps/dir/?api=1&destination=' + latitude + ',' +
                        longitude;
                    window.open(url, '_blank');
                };
                return div;
            };

            directionsButton.addTo(map);
        });
    </script>
    <script>
        const shareBtn = document.getElementById('share-btn');
        shareBtn.addEventListener('click', async () => {
            const shareData = {
                title: '{{ $zone->name }}',
                text: `{!! $zone->description ?? 'Thông tin chi tiết về phòng trọ.' !!}`,
                url: '{{ url()->current() }}'
            };
            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                } catch (error) {
                    console.log('Lỗi chia sẻ:', error);
                }
            } else {
                // Nếu không hỗ trợ navigator.share, hiển thị liên kết chia sẻ
                const fallbackUrl =
                    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareData.url)}`;
                window.open(fallbackUrl, '_blank');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.more-images').on('click', function(e) {
                e.preventDefault();
                // Mở slide ảnh với tất cả các hình ảnh
                $('.slider-for-01').slick('slickGoTo', 4); // Chuyển đến hình ảnh thứ 5
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('.delete-comment').on('click', function(e) {
                e.preventDefault();
                var commentId = $(this).data('comment-id');

                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Bạn sẽ không thể hoàn tác hành động này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý, xóa nó!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('client.danh-gia') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                action: 'delete',
                                comment_id: commentId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Đã xóa!',
                                        'Bình luận của bạn đã được xóa.',
                                        'success'
                                    );
                                    $('#comment-' + commentId).remove();
                                } else {
                                    Swal.fire(
                                        'Lỗi!',
                                        'Không thể xóa bình luận.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Lỗi!',
                                    'Đã xảy ra lỗi khi xóa bình luận.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script> --}}

    {{-- <script>
    $(document).ready(function() {
        $('#bookingForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của form

            // Lấy dữ liệu từ form
            var formData = $(this).serialize(); // Lấy tất cả dữ liệu trong form

            // Hiển thị popup xác nhận trước khi gửi
            Swal.fire({
                title: 'Xác nhận đặt phòng',
                text: "Bạn có chắc chắn muốn đặt phòng này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).attr('action'), // URL gửi đến
                        type: 'POST', // Phương thức gửi
                        data: formData, // Dữ liệu gửi đi
                        success: function(response) {
                            // Xử lý phản hồi thành công
                            Swal.fire(
                                'Thành công!',
                                'Đặt phòng thành công!',
                                'success'
                            );
                            $('#bookingModal').modal('hide'); // Đóng modal nếu cần
                            // Có thể thêm mã để làm mới danh sách hoặc cập nhật giao diện
                        },
                        error: function(xhr) {
                            // Xử lý lỗi
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                // Hiển thị lỗi nếu có
                                $.each(errors, function(key, value) {
                                    Swal.fire(
                                        'Lỗi!',
                                        value[0],
                                        'error'
                                    ); // Hiển thị thông báo lỗi đầu tiên
                                });
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    'Đã xảy ra lỗi, vui lòng thử lại!',
                                    'error'
                                ); // Thông báo lỗi chung
                            }
                        }
                    });
                }
            });
        });
    });
</script> --}}
    <script>
        $(document).on('click', '.room-select', function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a>

            // Xóa lớp 'bg-primary' và 'text-white' khỏi tất cả các phòng
            $('.room-select .border').removeClass('bg-primary text-white');

            // Thêm lớp 'bg-primary' và 'text-white' vào phòng được nhấp
            $(this).find('.border').addClass('bg-primary text-white');

            // Lấy thông tin phòng từ thuộc tính data
            var roomTitle = $(this).data('room-title');
            var roomId = $(this).data('room-id');
            var roomPrice = $(this).data('room-price');
            var formattedPrice = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
            }).format(roomPrice);

            // Cập nhật thông tin cần thiết cho modal
            $('#room-id').val(roomId);
            $('#room-price').text(formattedPrice);

            // Hiển thị nút "Đặt Phòng"
            $('#book-room-btn').show();
        });

        // Xử lý sự kiện khi nhấp vào nút "Đặt Phòng"
        $('#book-room-btn').on('click', function() {
            // Hiển thị modal
            $('#bookingModal').modal('show');
        });
    </script>
    <script>
        document.getElementById('submitBooking').addEventListener('click', function() {
            const form = document.getElementById('bookingForm');
            const formData = new FormData(form); // Lấy dữ liệu từ form

            // Gửi yêu cầu AJAX
            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Thêm token CSRF
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // Hiển thị thông báo thành công
                        Swal.fire('Thành công!', data.message, 'success');
                        // Có thể thêm mã để cập nhật giao diện nếu cần
                    } else if (data.error) {
                        // Hiển thị thông báo lỗi
                        Swal.fire('Có lỗi xảy ra!', data.error, 'error');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    Swal.fire('Có lỗi xảy ra!', 'Vui lòng thử lại sau.', 'error');
                });
        });
    </script>
@endpush
