<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
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
                            {{-- <input type="text" data-kt-user-table-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search owner" /> --}}
                            <input type="text" wire:model.lazy="search" wire:keydown.debounce.300ms="$refresh"
                                name="search" placeholder="Tìm kiếm đơn"
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
                                    <div class="fs-5 text-dark fw-bolder">Lựa chọn</div>
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
                                    <!-- <div class="mb-10">
                                        <label class="form-label fs-6 fw-bold">Two Step Verification:</label>
                                        <select class="form-select form-select-solid fw-bolder"
                                            data-kt-select2="true" data-placeholder="Select option"
                                            data-allow-clear="true" data-kt-user-table-filter="two-step"
                                            data-hide-search="true">
                                            <option></option>
                                            <option value="Enabled">Enabled</option>
                                        </select>
                                    </div> -->
                                    <!--end::Input group-->
                                    <!--begin::Actions-->

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

                        <!--end::Group actions-->
                        <!--begin::Modal - Adjust Balance-->

                        <!--end::Modal - New Card-->
                        <!--begin::Modal - Add task-->
                        <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header" id="kt_modal_add_user_header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bolder">Add User</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                            data-kt-users-modal-action="close">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                        rx="1" transform="rotate(-45 6 17.3137)"
                                                        fill="black" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                        <!--begin::Form-->
                                        <form id="kt_modal_add_user_form" class="form" action="#">
                                            <!--begin::Scroll-->
                                            <div class="d-flex flex-column scroll-y me-n7 pe-7"
                                                id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                                data-kt-scroll-activate="{default: false, lg: true}"
                                                data-kt-scroll-max-height="auto"
                                                data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                                data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                                data-kt-scroll-offset="300px">
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
                                                    <!--end::Label-->
                                                    <!--begin::Image input-->
                                                    <div class="image-input image-input-outline"
                                                        data-kt-image-input="true"
                                                        style="background-image: url(assets/media/avatars/blank.png)">
                                                        <!--begin::Preview existing avatar-->
                                                        <div class="image-input-wrapper w-125px h-125px"
                                                            style="background-image: url(assets/media/avatars/150-1.jpg);">
                                                        </div>
                                                        <!--end::Preview existing avatar-->
                                                        <!--begin::Label-->
                                                        <label
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="change"
                                                            data-bs-toggle="tooltip" title="Change avatar">
                                                            <i class="bi bi-pencil-fill fs-7"></i>
                                                            <!--begin::Inputs-->
                                                            <input type="file" name="avatar"
                                                                accept=".png, .jpg, .jpeg" />
                                                            <input type="hidden" name="avatar_remove" />
                                                            <!--end::Inputs-->
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Cancel-->
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="cancel"
                                                            data-bs-toggle="tooltip" title="Cancel avatar">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </span>
                                                        <!--end::Cancel-->
                                                        <!--begin::Remove-->
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="remove"
                                                            data-bs-toggle="tooltip" title="Remove avatar">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </span>
                                                        <!--end::Remove-->
                                                    </div>
                                                    <!--end::Image input-->
                                                    <!--begin::Hint-->
                                                    <div class="form-text">Allowed file types: png, jpg, jpeg.
                                                    </div>
                                                    <!--end::Hint-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-bold fs-6 mb-2">Full Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="user_name"
                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                        placeholder="Full name" value="Emma Smith" />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-bold fs-6 mb-2">Email</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="email" name="user_email"
                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                        placeholder="example@domain.com"
                                                        value="e.smith@kpmg.com.au" />
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-bold fs-6 mb-5">Role</label>
                                                    <!--end::Label-->
                                                    <!--begin::Roles-->
                                                    <!--begin::Input row-->
                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="user_role"
                                                                type="radio" value="0"
                                                                id="kt_modal_update_role_option_0"
                                                                checked='checked' />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                for="kt_modal_update_role_option_0">
                                                                <div class="fw-bolder text-gray-800">
                                                                    Administrator
                                                                </div>
                                                                <div class="text-gray-600">Best for business
                                                                    owners
                                                                    and
                                                                    company administrators</div>
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Input row-->
                                                    <div class='separator separator-dashed my-5'></div>
                                                    <!--begin::Input row-->
                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="user_role"
                                                                type="radio" value="1"
                                                                id="kt_modal_update_role_option_1" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                for="kt_modal_update_role_option_1">
                                                                <div class="fw-bolder text-gray-800">Developer
                                                                </div>
                                                                <div class="text-gray-600">Best for developers
                                                                    or
                                                                    people primarily using the API</div>
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Input row-->
                                                    <div class='separator separator-dashed my-5'></div>
                                                    <!--begin::Input row-->
                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="user_role"
                                                                type="radio" value="2"
                                                                id="kt_modal_update_role_option_2" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                for="kt_modal_update_role_option_2">
                                                                <div class="fw-bolder text-gray-800">Analyst
                                                                </div>
                                                                <div class="text-gray-600">Best for people who
                                                                    need
                                                                    full access to analytics data, but don't
                                                                    need to
                                                                    update business settings</div>
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Input row-->
                                                    <div class='separator separator-dashed my-5'></div>
                                                    <!--begin::Input row-->
                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="user_role"
                                                                type="radio" value="3"
                                                                id="kt_modal_update_role_option_3" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                for="kt_modal_update_role_option_3">
                                                                <div class="fw-bolder text-gray-800">Support
                                                                </div>
                                                                <div class="text-gray-600">Best for employees
                                                                    who
                                                                    regularly refund payments and respond to
                                                                    disputes
                                                                </div>
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Input row-->
                                                    <div class='separator separator-dashed my-5'></div>
                                                    <!--begin::Input row-->
                                                    <div class="d-flex fv-row">
                                                        <!--begin::Radio-->
                                                        <div class="form-check form-check-custom form-check-solid">
                                                            <!--begin::Input-->
                                                            <input class="form-check-input me-3" name="user_role"
                                                                type="radio" value="4"
                                                                id="kt_modal_update_role_option_4" />
                                                            <!--end::Input-->
                                                            <!--begin::Label-->
                                                            <label class="form-check-label"
                                                                for="kt_modal_update_role_option_4">
                                                                <div class="fw-bolder text-gray-800">Trial
                                                                </div>
                                                                <div class="text-gray-600">Best for people who
                                                                    need
                                                                    to
                                                                    preview content data, but don't need to make
                                                                    any
                                                                    updates</div>
                                                            </label>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Radio-->
                                                    </div>
                                                    <!--end::Input row-->
                                                    <!--end::Roles-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Scroll-->
                                            <!--begin::Actions-->
                                            <div class="text-center pt-15">
                                                <button type="reset" class="btn btn-light me-3"
                                                    data-kt-users-modal-action="cancel">Discard</button>
                                                <button type="submit" class="btn btn-primary"
                                                    data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait...
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Modal body-->
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
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
                            <thead class="table text-nowrap">
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="w-10 text-nowrap">Mã đơn</th>
                                    <th class="w-10 text-nowrap">Tên tài khoản</th>
                                    <th class="w-15 text-nowrap">Số tài khoản</th>
                                    <th class="w-20 text-nowrap">Tên ngân hàng</th>
                                    <th class="w-15 text-nowrap">Số tiền rút</th>
                                    <th class="w-20 text-nowrap">Ngày rút</th>
                                    <th class="w-10 text-center text-nowrap">Tác vụ</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-bold">
                                @if ($payouts->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu.</td>
                                    </tr>
                                @else
                                    @foreach ($payouts as $payout)
                                        <tr>
                                            <td>{{ $payout->single_code }}</td>
                                            <td>{{ $payout->card_holder_name }}</td>
                                            <td>{{ $payout->account_number }}</td>
                                            <td>{{ $payout->bank_name }}</td>
                                            <td>{{ number_format($payout->amount, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $payout->requested_at->format('d/m/Y') }}</td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-light btn-active-light-primary btn-sm dropdown-toggle"
                                                        type="button" id="dropdownMenuButton-{{ $payout->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Tác vụ
                                                    </button>
                                                    <ul class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                        aria-labelledby="dropdownMenuButton-{{ $payout->id }}">
                                                        <li class="menu-item px-3">
                                                            <form
                                                                action="{{ route('admin.browse-payout', $payout->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="dropdown-item menu-link px-3 border-0 bg-transparent text-start w-100">
                                                                    Duyệt</button>
                                                            </form>
                                                        </li>
                                                        <li class="menu-item px-3">
                                                            <button type="button"
                                                                class="dropdown-item menu-link px-3 border-0 bg-transparent text-start w-100"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectPayoutModal-{{ $payout->id }}">
                                                                Từ chối
                                                            </button>
                                                        </li>
                                                    </ul>
                                                    <!-- Reject Payout Modal -->
                                                    <div class="modal fade"
                                                        id="rejectPayoutModal-{{ $payout->id }}" tabindex="-1"
                                                        aria-labelledby="rejectPayoutModalLabel-{{ $payout->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="rejectPayoutModalLabel-{{ $payout->id }}">
                                                                        Từ chối yêu cầu rút tiền</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.reject-payout', $payout->id) }}"
                                                                    method="POST"
                                                                    id="rejectPayoutForm-{{ $payout->id }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                for="rejectReason-{{ $payout->id }}"
                                                                                class="form-label text-start d-block">Lý
                                                                                do từ chối</label>
                                                                            <textarea class="form-control" id="rejectReason-{{ $payout->id }}" name="rejectionReason" rows="3"></textarea>
                                                                            <div class="invalid-feedback">
                                                                                Vui lòng nhập lý do từ chối.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Hủy</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Xác nhận từ
                                                                            chối</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!--end::Action=-->
                                        </tr>
                                        <!--end::Table row-->
                                    @endforeach

                                @endif
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->

                    <!-- Phân trang -->
                    @if ($payouts->total() > 0)
                        @if ($payouts->hasPages())
                            <nav aria-label="Page navigation" class="mb-2">
                                <ul class="pagination pagination-sm rounded-active justify-content-center">
                                    {{-- Liên kết Trang Đầu --}}
                                    <li class="page-item {{ $payouts->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link hover-white" wire:click="gotoPage(1)"
                                            wire:loading.attr="disabled" rel="first"
                                            aria-label="@lang('pagination.first')"><i
                                                class="fas fa-angle-double-left"></i></a>
                                    </li>

                                    {{-- Liên kết Trang Trước --}}
                                    <li class="page-item {{ $payouts->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link hover-white" wire:click="previousPage"
                                            wire:loading.attr="disabled" rel="prev"
                                            aria-label="@lang('pagination.previous')"><i class="fas fa-angle-left"></i></a>
                                    </li>

                                    @php
                                        $totalPages = $payouts->lastPage();
                                        $currentPage = $payouts->currentPage();
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
                                            <a class="page-link hover-white"
                                                wire:click="gotoPage({{ $totalPages }})"
                                                wire:loading.attr="disabled">{{ $totalPages }}</a>
                                        </li>
                                    @endif

                                    {{-- Liên kết Trang Tiếp --}}
                                    <li class="page-item {{ !$payouts->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link hover-white" wire:click="nextPage"
                                            wire:loading.attr="disabled" rel="next"
                                            aria-label="@lang('pagination.next')"><i class="fas fa-angle-right"></i></a>
                                    </li>

                                    {{-- Liên kết Trang Cuối --}}
                                    <li class="page-item {{ !$payouts->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                            wire:loading.attr="disabled" rel="last"
                                            aria-label="@lang('pagination.last')"><i
                                                class="fas fa-angle-double-right"></i></i></i></a>
                                    </li>
                                </ul>
                            </nav>

                        @endif

                    @endif
                </div>

                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rejectForms = document.querySelectorAll('[id^="rejectPayoutForm-"]');

        rejectForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const reasonTextarea = this.querySelector('textarea[name="rejectionReason"]');

                if (reasonTextarea.value.trim() === '') {
                    reasonTextarea.classList.add('is-invalid');
                    return;
                }

                reasonTextarea.classList.remove('is-invalid');
                this.submit();
            });
        });
    });
</script>
