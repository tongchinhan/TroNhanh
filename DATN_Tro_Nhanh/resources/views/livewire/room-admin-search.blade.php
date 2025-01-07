<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" wire:model.lazy="search" wire:keydown.debounce.300ms="$refresh"
                                name="search" placeholder="Tìm trọ"
                                class="form-control form-control-solid w-250px ps-14" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                            fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Lọc</button>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-bold">Lọc theo:</label>
                                        <select class="form-select form-select-solid fw-bolder sortby"
                                            wire:model.lazy="timeFilter" id="timeFilter"
                                            data-style="bg-transparent px-1 py-0 lh-1 font-weight-600 text-body">
                                            <option value="" selected>Chọn khoảng thời gian:</option>
                                            <option value="1_day">Hôm qua</option>
                                            <option value="7_day">7 ngày</option>
                                            <option value="1_month">1 tháng</option>
                                            <option value="3_month">3 tháng</option>
                                            <option value="6_month">6 tháng</option>
                                            <option value="1_year">1 năm</option>
                                        </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->

                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Filter-->
                            <!--begin::Export-->

                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->

                        <!--end::Modal - New Card-->
                        <!--begin::Modal - Add task-->

                        <!--end::Modal - Add task-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">Ảnh</th>
                                    <th class="min-w-125px">Tiêu Đề</th>

                                    {{-- <th class="min-w-125px">Số lượng</th> --}}
                                    <th class="min-w-125px">Giá</th>
                                    <th class="min-w-125px">Trạng Thái</th>
                                    <th class="text-end min-w-125px">Tác vụ</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold">
                                <!--begin::Table row-->
                                @if ($rooms->isEmpty())
                                    <!-- Hiển thị khi không có dữ liệu -->
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu.</td>
                                    </tr>
                                @else
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <!--begin::Checkbox-->

                                            <!--end::Checkbox-->
                                            <!--begin::User=-->
                                            <td class="d-flex align-items-center min-w-125px">
                                                <!--begin:: Avatar -->
                                                <div class="symbol symbol-100px overflow-hidden me-3">
                                                    <a href="">
                                                        {{-- {{ route('client.detail-room', ['slug' => $room->slug]) }} --}}
                                                        <div class="symbol-label">
                                                            @if (!empty($room->images))
                                                                <img src="{{ asset('assets/images/' . $room->images) }}"
                                                                    alt="{{ $room->title }}" class="full-image">
                                                            @else
                                                                <img src="{{ asset('assets/images/blog-details.jpg') }}"
                                                                    alt="{{ $room->title }}" class="full-image">
                                                            @endif
                                                        </div>
                                                    </a>

                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::User details-->
                                                <div class="d-flex flex-column">
                                                    <a href="" class="text-gray-800 text-hover-primary mb-1"></a>
                                                </div>
                                                <!--begin::User details-->
                                            </td>
                                            <!--end::User=-->
                                            <!--begin::Role=-->

                                            <!--end::Role=-->
                                            <!--begin::Last login=-->
                                            <td>
                                                <small> {{ $room->title }}</small>
                                            </td>
                                            <!--end::Last login=-->
                                            <!--begin::Two step=-->

                                            <!--end::Two step=-->
                                            <!--begin::Joined-->
                                            <td><small>{{ $room->price }} VND</small></td>
                                            <!--begin::Joined-->
                                            <td><small>{{ $room->status }}</small></td>
                                            <!--begin::Action=-->
                                            {{-- <td class="text-end">
                                                <a href="#"
                                                    class="btn btn-light btn-active-light-primary btn-sm"
                                                    data-kt-menu-trigger="click"
                                                    data-kt-menu-placement="bottom-end">Tác
                                                    vụ
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-5 m-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="26"
                                                            height="24" viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon--></a>
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                    data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('admin.update-room-show', ['slug' => $room->slug]) }}"
                                                            class="menu-link px-3">Chỉnh sửa</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <form action="{{ route('admin.destroy-room', $room->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="menu-link px-3 border-0 bg-transparent text-start">Xóa</button>
                                                        </form>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                            </td> --}}
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle"
                                                        type="button" id="dropdownMenuButton-{{ $room->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Tác vụ
                                                        {{-- <span class="svg-icon svg-icon-5 m-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="26"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </span> --}}
                                                    </button>
                                                    <ul class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                        aria-labelledby="dropdownMenuButton-{{ $room->id }}">
                                                        {{-- <li class="menu-item px-3">
                                                            <a href="{{ route('admin.update-room-show', ['slug' => $room->slug]) }}"
                                                                class="dropdown-item menu-link px-3">Chỉnh sửa</a>
                                                        </li> --}}
                                                        <li class="menu-item px-3">
                                                            <form action="{{ route('admin.destroy-room', $room->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="dropdown-item menu-link px-3 border-0 bg-transparent text-start w-100">Xóa</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <!--end::Action=-->
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>

                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                @if ($rooms->total() > 0)
                    @if ($rooms->hasPages())
                        <nav aria-label="Page navigation" class="mb-2">
                            <ul class="pagination pagination-sm rounded-active justify-content-center">
                                {{-- Liên kết Trang Đầu --}}
                                <li class="page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage(1)"
                                        wire:loading.attr="disabled" rel="first" aria-label="@lang('pagination.first')"><i
                                            class="fas fa-angle-double-left"></i></a>
                                </li>

                                {{-- Liên kết Trang Trước --}}
                                {{-- <li class="page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="previousPage"
                                        wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')"><i
                                            class="fas fa-angle-left"></i></a>
                                </li> --}}

                                @php
                                    $totalPages = $rooms->lastPage();
                                    $currentPage = $rooms->currentPage();
                                    $visiblePages = 3; // Số trang giữa
                                @endphp

                                {{-- Trang đầu --}}
                                <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage(1)"
                                        wire:loading.attr="disabled">1</a>
                                </li>

                                {{-- Dấu ba chấm đầu --}}
                                @if ($currentPage > 3)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                {{-- Các trang giữa --}}
                                @for ($i = max(2, $currentPage - 1); $i <= min($totalPages - 1, $currentPage + 1); $i++)
                                    @if ($i > 1 && $i < $totalPages)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link hover-white"
                                                wire:click="gotoPage({{ $i }})"
                                                wire:loading.attr="disabled">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- Dấu ba chấm cuối --}}
                                @if ($currentPage < $totalPages - 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                {{-- Trang cuối --}}
                                @if ($totalPages > 1)
                                    <li class="page-item {{ $currentPage == $totalPages ? 'active' : '' }}">
                                        <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                            wire:loading.attr="disabled">{{ $totalPages }}</a>
                                    </li>
                                @endif

                                {{-- Liên kết Trang Tiếp --}}
                                {{-- <li class="page-item {{ !$rooms->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="nextPage"
                                        wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')"><i
                                            class="fas fa-angle-right"></i></a>
                                </li> --}}

                                {{-- Liên kết Trang Cuối --}}
                                <li class="page-item {{ !$rooms->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                        wire:loading.attr="disabled" rel="last" aria-label="@lang('pagination.last')"><i
                                            class="fas fa-angle-double-right"></i></a>
                                </li>
                            </ul>
                        </nav>

                    @endif

                @endif
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
</div>
