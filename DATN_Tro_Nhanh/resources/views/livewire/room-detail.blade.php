<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="mb-6">
            <div class="row">
                <div class="col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center">
                    <div class="d-flex form-group mb-0 align-items-center">
                        {{-- <h5 for="invoice-list_length" class="d-block mr-2 mb-0">Tên khu: {{ $zone->name }}</h5> --}}
                    </div>
                    <div class="ml-2 align-self-center">
                        {{-- <a href="{{ route('owners.zone-post', $room->slug) }}" class="btn btn-primary btn-lg"
                            tabindex="0"><span>Thêm
                                mới</span></a> --}}
                    </div>

                </div>

                <div class="col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3">

                    <div class="input-group input-group-lg bg-white mb-0 position-relative mr-2">
                        <input wire:model.lazy="searchResident" wire:keydown.debounce.300ms="$refresh" type="text"
                            class="form-control bg-transparent border-0 shadow-none text-body"
                            placeholder="Tìm kiếm tên người ở..." aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-append position-absolute pos-fixed-right-center">
                            <button class="btn bg-transparent border-0 text-gray lh-1" type="button"><i
                                    class="fal fa-search"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover bg-white border rounded-lg">
                        <thead>
                            <tr role="row">
                                {{-- <th class="no-sort py-6 pl-6">
                                    <label class="new-control new-checkbox checkbox-primary m-auto">
                                        <input type="checkbox"
                                            class="new-control-input chk-parent select-customers-info">
                                    </label>
                                </th> --}}
                                <th class="py-6 text-start" style="white-space: nowrap;">Khách hàng</th>
                              
                                <th class="py-6 text-start" style="white-space: nowrap;">Số điện thoại</th>
                                {{-- <th class="py-6 text-start">Lý do từ chối</th> --}}
                                <th class="py-6 text-start" style="white-space: nowrap;">Trạng thái</th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Xem hồ sơ</th>
                                <th class="py-6 text-start ">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($residents->isEmpty())


                                <tr>
                                    <td colspan="6" class="text-center" style="white-space: nowrap;">Khu vực chưa có
                                        phòng trọ nào.</td>
                                </tr>
                            @else
                                @foreach ($residents as $item)
                                    <tr>
                                        {{-- <td class="py-6 pl-6" style="white-space: nowrap;">
                                            <label class="new-control new-checkbox checkbox-primary m-auto">
                                                <input type="checkbox"
                                                    class="new-control-input chk-parent select-customers-info">
                                            </label>
                                        </td> --}}
                                        <td class="align-middle" style="white-space: nowrap;">
                                            <small>{{ $item->tenant->name }}</small>
                                        </td>
                                     
                                        <td class="align-middle" style="white-space: nowrap;"> <small>
                                                {{-- @if ($room->residents && $room->residents->isNotEmpty())
                                                    {{ $room->residents->first()->tenant->phone ?? 'Không có' }}
                                                @else
                                                    Phòng trống
                                                @endif --}}

                                                {{ $item->tenant->phone ?? 'Không có dữ liệu ' }}

                                            </small></td>


                                        <td class="align-middle" style="white-space: nowrap;">
                                            <small>

                                                <span class="badge badge-green text-capitalize">Đang tạm trú</span>

                                            </small>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            @if ($item->status == $user_is_in)
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#identityModal{{ $item->tenant->id }}">
                                                    Xem hồ sơ
                                                </button>
                                            @endif
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            @if ($room->residents->where('status', $user_is_in)->isNotEmpty())
                                                @php
                                                    $resident = $room->residents->where('status', $user_is_in)->first();
                                                    $tenant = $resident->tenant;
                                                @endphp
                                                @if ($resident->status == $user_is_in)
                                                    {{-- <a href="{{ route('owners.detail-room', $room->slug) }}"
                                                        type="button" class="btn btn-primary btn-sm">
                                                        <i class="fal fa-eye"></i>
                                                    </a> --}}
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#invoiceModal{{ $item->id }}">
                                                        <i class="fal fa-pencil-alt"></i>
                                                    </button>

                                                    <!-- Modal -->

                                                    <div class="modal fade" id="invoiceModal{{ $item->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="invoiceModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="invoiceModalLabel{{ $item->tenant->id }}">
                                                                        Tạo hóa đơn cho {{ $item->tenant->name }}
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="formBills{{ $item->id }}"
                                                                        action="{{ route('owners.bills-store') }}"
                                                                        method="POST"
                                                                        onsubmit="event.preventDefault(); submitForm('formBills{{ $item->id }}');">
                                                                        @csrf
                                                                        <input type="hidden" name="payer_id"
                                                                            value="{{ $item->tenant_id }}">
                                                                        <input type="hidden" name="creator_id"
                                                                            value="{{ auth()->user()->id }}">
                                                                        <div class="row">
                                                                            <!-- Cột trái -->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="name{{ $item->id }}">Tên
                                                                                        người ở:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="name{{ $item->id }}"
                                                                                        value="{{ $item->tenant->name }}"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="room{{ $item->id }}">Tên
                                                                                        phòng:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="room{{ $item->id }}"
                                                                                        value="{{ $item->room->title }}"
                                                                                        readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="payment_due_date{{ $item->id }}">Hạn
                                                                                        thanh toán:</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        id="payment_due_date{{ $item->id }}"
                                                                                        name="payment_due_date"
                                                                                        min="{{ date('Y-m-d') }}">
                                                                                    <span class="text-danger"
                                                                                        id="payment_due_date-error{{ $item->id }}"></span>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Cột phải -->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="title{{ $item->id }}">Tiêu
                                                                                        đề:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="title{{ $item->id }}"
                                                                                        name="title" required
                                                                                        autocomplete="off"
                                                                                        placeholder="Nhập tiêu đề hóa đơn">
                                                                                    <span class="text-danger"
                                                                                        id="title-error{{ $item->id }}"></span>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="amount">Số
                                                                                        tiền:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="amount" name="amount"
                                                                                        required
                                                                                        placeholder="Nhập số tiền"
                                                                                        oninput="this.value = formatNumber(this.value)">
                                                                                    <span class="text-danger"
                                                                                        id="amount-error"></span>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="description{{ $item->id }}">Mô
                                                                                        tả:</label>
                                                                                    <textarea class="form-control" id="description{{ $item->id }}" name="description" rows="3"
                                                                                        placeholder="Nhập mô tả chi tiết về hóa đơn" required></textarea>
                                                                                    <span class="text-danger"
                                                                                        id="description-error{{ $item->id }}"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer text-right">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Đóng</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Tạo hóa
                                                                                đơn</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('owners.erase-tenant', $resident->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fal fa-trash-alt"></i></button>
                                                    </form>
                                                @endif
                                            @else
                                                <form action="{{ route('owners.delete-room-in-zone', $room->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fal fa-trash-alt"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    @if ($residents->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm rounded-active justify-content-center">
                                {{-- Liên kết Trang Đầu --}}
                                <li class="page-item {{ $residents->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage(1)"
                                        wire:loading.attr="disabled">
                                        &lt;&lt;
                                    </a>
                                </li>

                                {{-- Liên kết Trang Trước --}}
                                <li class="page-item {{ $residents->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="previousPage"
                                        wire:loading.attr="disabled">
                                        &lt;
                                    </a>
                                </li>

                                @php
                                    $window = 2; // Số trang hiển thị ở mỗi bên của trang hiện tại
                                    $totalPages = $residents->lastPage();
                                    $currentPage = $residents->currentPage();
                                    $startPage = max($currentPage - $window, 1);
                                    $endPage = min($currentPage + $window, $totalPages);
                                @endphp

                                @if ($startPage > 1)
                                    <li class="page-item">
                                        <a class="page-link hover-white" wire:click="gotoPage(1)"
                                            wire:loading.attr="disabled">1</a>
                                    </li>
                                    @if ($startPage > 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link hover-white" wire:click="gotoPage({{ $i }})"
                                            wire:loading.attr="disabled">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($endPage < $totalPages)
                                    @if ($endPage < $totalPages - 1)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                            wire:loading.attr="disabled">{{ $totalPages }}</a>
                                    </li>
                                @endif

                                {{-- Liên kết Trang Tiếp --}}
                                <li class="page-item {{ !$residents->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="nextPage"
                                        wire:loading.attr="disabled">
                                        &gt;
                                    </a>
                                </li>

                                {{-- Liên kết Trang Cuối --}}
                                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                        wire:loading.attr="disabled">
                                        &gt;&gt;
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- @foreach ($room->residents as $resident)
        <div class="modal fade" id="invoiceModal{{ $resident->id }}" tabindex="-1" role="dialog"
            aria-labelledby="invoiceModalLabel{{ $resident->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModalLabel{{ $resident->tenant->id }}">Tạo hóa đơn cho

                            {{ $resident->tenant->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formBills" action="{{ route('owners.bills-store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payer_id" value="{{ $resident->tenant_id }}">
                            <input type="hidden" name="creator_id" value="{{ auth()->user()->id }}">
                            <div class="row">
                                <!-- Cột trái -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên người ở:</label>
                                        <input type="text" class="form-control" id="name"
                                            value="{{ $resident->tenant->name }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="room">Tên phòng:</label>
                                        <input type="text" class="form-control" id="room"
                                            value="{{ $resident->room->title }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_due_date">Hạn thanh toán:</label>
                                        <input type="date" class="form-control" id="payment_due_date"
                                            name="payment_due_date" min="{{ date('Y-m-d') }}">
                                        <span class="text-danger" id="payment_due_date-error"></span>
                                    </div>



                                </div>

                                <!-- Cột phải -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Tiêu đề:</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            required autocomplete="off" placeholder="Nhập tiêu đề hóa đơn">
                                        <span class="text-danger" id="title-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Số tiền:</label>
                                        <input type="number" class="form-control" id="amount" name="amount"
                                            required min="0" step="0.01" placeholder="Nhập số tiền">
                                        <span class="text-danger" id="amount-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả:</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"
                                            placeholder="Nhập mô tả chi tiết về hóa đơn" required></textarea>
                                        <span class="text-danger" id="description-error"></span>
                                    </div>



                                </div>
                            </div>
                            <div class="modal-footer text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}
    {{-- @if ($room->isNotEmpty()) <!-- Kiểm tra xem có phòng không -->
        @foreach ($room as $room)
            <!-- Lặp qua từng phòng -->
            @php
                // Lấy cư dân trong phòng hiện tại
                $roomResidents = $residents->where('room_id', $room->id);
            @endphp

            @if ($roomResidents->isNotEmpty())
                <!-- Kiểm tra xem có cư dân không -->
                @foreach ($roomResidents as $resident)
                    <div class="modal fade" id="invoiceModal{{ $resident->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="invoiceModalLabel{{ $resident->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="invoiceModalLabel{{ $resident->tenant->id }}">Tạo hóa
                                        đơn cho
                                        {{ $resident->tenant->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formBills" action="{{ route('owners.bills-store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payer_id" value="{{ $resident->tenant_id }}">
                                        <input type="hidden" name="creator_id" value="{{ auth()->user()->id }}">
                                        <div class="row">
                                            <!-- Cột trái -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Tên người ở:</label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="{{ $resident->tenant->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="room">Tên phòng:</label>
                                                    <input type="text" class="form-control" id="room"
                                                        value="{{ $room->title }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="payment_due_date">Hạn thanh toán:</label>
                                                    <input type="date" class="form-control" id="payment_due_date"
                                                        name="payment_due_date" min="{{ date('Y-m-d') }}">
                                                    <span class="text-danger" id="payment_due_date-error"></span>
                                                </div>
                                            </div>

                                            <!-- Cột phải -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Tiêu đề:</label>
                                                    <input type="text" class="form-control" id="title"
                                                        name="title" required autocomplete="off"
                                                        placeholder="Nhập tiêu đề hóa đơn">
                                                    <span class="text-danger" id="title-error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="amount">Số tiền:</label>
                                                    <input type="number" class="form-control" id="amount"
                                                        name="amount" required min="0" step="0.01"
                                                        placeholder="Nhập số tiền">
                                                    <span class="text-danger" id="amount-error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Mô tả:</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"
                                                        placeholder="Nhập mô tả chi tiết về hóa đơn" required></textarea>
                                                    <span class="text-danger" id="description-error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer text-right">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
        <!-- Thông báo nếu không có phòng -->
    @endif --}}
    @foreach ($residents as $item)
        @if ($item->status == $user_is_in)
            @php
                $tenant = $item->tenant; // Lấy tenant từ item hiện tại
            @endphp
            <div class="modal fade" id="identityModal{{ $tenant->id }}" tabindex="-1" role="dialog"
                aria-labelledby="identityModalLabel{{ $tenant->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="identityModalLabel{{ $tenant->id }}">Ảnh định danh của
                                {{ $tenant->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @php
                                $frontImage = $tenant->identity ? $tenant->identity->front_id_card_image : null;
                                $backImage = $tenant->identity ? $tenant->identity->back_id_card_image : null;
                                $public = 2;
                            @endphp
                            @if ($tenant->identity && $tenant->status == $public)
                                <div class="row">
                                    @if ($frontImage)
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ asset('assets/images/register_owner/' . $frontImage) }}"
                                                data-fancybox="gallery">
                                                <img src="{{ asset('assets/images/register_owner/' . $frontImage) }}"
                                                    alt="Front ID Card" class="img-fluid">
                                            </a>
                                        </div>
                                    @endif

                                    @if ($backImage)
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ asset('assets/images/register_owner/' . $backImage) }}"
                                                data-fancybox="gallery">
                                                <img src="{{ asset('assets/images/register_owner/' . $backImage) }}"
                                                    alt="Back ID Card" class="img-fluid">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p>Không có ảnh định danh hoặc thông tin chưa được công khai.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <script>
        function formatNumber(value) {
            // Xóa tất cả ký tự không phải số
            value = value.replace(/[^0-9]/g, '');
            // Định dạng số với dấu phẩy
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
       <script>
        function submitForm(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
    
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Thêm token CSRF
                }
            })
            .then(response => response.json())
            .then(data => {
                // ... existing code ...
                if (data.status === 'success') {
                    Swal.close();
                    Swal.fire({
                        title: 'Thành công!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Tải lại trang
                        }
                    });
                } else {
                    // Hiển thị thông báo lỗi nếu có
                    Swal.fire({
                        title: 'Lỗi!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
                // ... existing code ...
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            });
        }
    </script>
</main>
{{-- format tiền --}}

<!-- Modal -->
