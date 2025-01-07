 @extends('layouts.owner')
 @section('titleOwners', 'Danh Sách Phòng Trọ | TRỌ NHANH')
 @section('contentOwners')

     @livewire('room-owners-list')

 @endsection
 @push('styleOwners')
     {{-- <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description" content="Real Estate Html Template">
     <meta name="author" content="TRỌ NHANH">
     <meta name="generator" content="TRỌ NHANH">
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
     <link rel="stylesheet" href="{{ asset('assets/css/themes.css') }}">

     <!-- Favicons -->
     <link rel="shortcut icon" href="{{ asset('assets/images/logo-nav.png') }}" />
     <!-- Twitter -->
     <meta name="twitter:card" content="summary">
     <meta name="twitter:site" content="@">
     <meta name="twitter:creator" content="@">
     <meta name="twitter:title" content="Home 01">
     <meta name="twitter:description" content="Real Estate Html Template">
     <meta name="twitter:image" content="{{ asset('images/tro-moi.png') }}">

     <!-- Facebook -->
     <meta property="og:url" content="">
     <meta property="og:title" content="Home 01">
     <meta property="og:description" content="Real Estate Html Template">
     <meta property="og:type" content="website">
     <meta property="og:image" content="{{ asset('images/tro-moi.png') }}">
     <meta property="og:image:type" content="image/png">
     <meta property="og:image:width" content="1200">
     <meta property="og:image:height" content="630"> --}}
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description"
         content="Danh sách khu trọ tại TRỌ NHANH. Tìm kiếm và lựa chọn các khu trọ phù hợp với nhu cầu của bạn, với thông tin chi tiết và chính xác nhất.">
     <meta name="author" content="TRỌ NHANH">
     <meta name="generator" content="TRỌ NHANH">
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
     <link rel="stylesheet" href="{{ asset('assets/css/themes.css') }}">
     <!-- Favicons -->
     <link rel="shortcut icon" href="{{ asset('assets/images/logo-nav.png') }}" />
     <!-- Twitter -->
     <meta name="twitter:card" content="summary_large_image">
     <meta name="twitter:site" content="@TroNanh">
     <meta name="twitter:creator" content="@TroNanh">
     <meta name="twitter:title" content="Danh Sách Khu Trọ tại TRỌ NHANH">
     <meta name="twitter:description"
         content="Khám phá danh sách các khu trọ với thông tin chi tiết, tiện ích và giá cả tại TRỌ NHANH. Tìm khu trọ phù hợp với nhu cầu của bạn.">
     <meta name="twitter:image" content="{{ asset('assets/images/tro-moi.png') }}">
     <!-- Facebook -->
     <meta property="og:url" content="{{ url()->current() }}">
     <meta property="og:title" content="Danh Sách Khu Trọ tại TRỌ NHANH">
     <meta property="og:description"
         content="Khám phá và lựa chọn các khu trọ phù hợp với nhu cầu của bạn. Xem thông tin chi tiết về các khu trọ tại TRỌ NHANH.">
     <meta property="og:type" content="website">
     <meta property="og:image" content="{{ asset('assets/images/tro-moi.png') }}">
     <meta property="og:image:type" content="image/png">
     <meta property="og:image:width" content="1200">
     <meta property="og:image:height" content="630">
 @endpush
 @push('scriptOwners')
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
     <script>
         document.addEventListener("livewire:load", function() {
             Livewire.hook('message.processed', (message, component) => {
                 $('.selectpicker').selectpicker('destroy');
                 $('.selectpicker').selectpicker();
             });
         });
     </script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Hiển thị thông báo thành công nếu có
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        @endif

        // Hiển thị thông báo lỗi nếu có
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        @endif
    </script>
     <script src="{{ asset('assets/js/alert-update-user.js') }}"></script>
     <script src="{{ asset('assets/js/alert-report.js') }}"></script>
 @endpush
