<main id="content" class="bg-gray-01">
    <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
        <div class="mb-6">
            <div class="row" wire:ignore>
                <div class="col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center">
                    <div class="d-flex form-group mb-0 align-items-center">
                        <label for="invoice-list_length" class="d-block mr-2 mb-0">Lọc:</label>
                        <select wire:model.lazy="timeFilter" name="invoice-list_length" id="invoice-list_length"
                            aria-controls="invoice-list" class="form-control form-control-lg mr-2 selectpicker"
                            data-style="bg-white btn-lg h-52 py-2 border">
                            <option value="">Mặc định</option>
                            <option value="1_day">Hôm qua</option>
                            <option value="7_day">7 ngày</option>
                            <option value="1_month">1 tháng</option>
                            <option value="3_month">3 tháng</option>
                            <option value="6_month">6 tháng</option>
                            <option value="1_year">1 năm</option>
                        </select>
                    </div>

                </div>
                <div class="col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3">
                    <div class="input-group input-group-lg bg-white mb-0 position-relative mr-2">
                        <input wire:model.lazy="search" wire:keydown.debounce.500ms="$refresh" type="text"
                            class="form-control bg-transparent border-1x" placeholder="Tìm kiếm..." aria-label=""
                            aria-describedby="basic-addon1">
                        <div class="input-group-append position-absolute pos-fixed-right-center">
                            <button class="btn bg-transparent border-0 text-gray lh-1" type="button"><i
                                    class="fal fa-search"></i></button>
                        </div>
                    </div>
                    <div class="align-self-center">
                        <button class="btn btn-danger btn-lg" tabindex="0" id='deleteSelected'
                            aria-controls="invoice-list"><span>Xóa</span></button>
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
                                <th class="no-sort py-6 pl-6" style="white-space: nowrap;">
                                    <label class="new-control new-checkbox checkbox-primary m-auto">
                                        <input type="checkbox" id='selectAll'
                                            class="new-control-input chk-parent select-customers-info">
                                    </label>
                                </th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Tên phòng</th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Tên người ở</th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Số điện thoại</th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Khu trọ</th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Trạng thái</th>
                                <th class="py-6 text-start" style="white-space: nowrap;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($residents->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center" style="white-space: nowrap;">Không có đơn
                                    </td>
                                </tr>
                            @else
                                @foreach ($residents as $resident)
                           
                                    <tr class="shadow-hover-xs-2" data-id="{{ $resident->id }}">
                                        <td class="py-6 pl-6 align-middle " style="white-space: nowrap;">
                                            <label class="new-control new-checkbox checkbox-primary m-auto">


                                                <input data-id="{{ $resident->id }}" type="checkbox"
                                                    class="child-chk" wire:model="selectedNotifications"
                                                    value="{{ $resident->id }}">
                                            </label>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            <small class="text">{{ $resident->room_title }}</small>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            <small>
                                                <a href="{{ route('client.client-agent-detail', $resident->tenant->slug) }}"
                                                    class="text-primary">
                                                    {{ $resident->tenant->name }}
                                                </a>
                                            </small>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            <small class="text">{{ $resident->tenant->phone }}</small>
                                        </td>
                                        <!-- <td class="align-middle description-column {{ empty($resident->description) ? 'd-none' : '' }}"
                                            style="white-space: nowrap;">
                                            <small class="text">{{ $resident->description }}</small>
                                        </td> -->


                                        <td class="align-middle" style="white-space: nowrap;">
                                            <small class="text">{{ $resident->zone_name }}</small>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            {{-- <small class="text">{{ $resident->zone_name }} --}}
                                                @if ($resident->status == 1)
                                                <span class="badge badge-yellow text-capitalize font-weight-normal fs-12">Đang xử
                                                    lý</span>
                                            @elseif ($resident->status == 2)
                                                <span class="badge badge-green text-capitalize font-weight-normal fs-12">Đã duyệt</span>
                                            @elseif ($resident->status == 3)
                                                <span class="badge badge-danger text-capitalize font-weight-normal fs-12">Bị từ chối</span>
                                            @else
                                                <span class="badge badge-light text-capitalize font-weight-normal fs-12">Không xác
                                                    định</span>
                                            @endif
                                            </small>
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap;">
                                            <form action="{{ route('owners.cancel-order', $resident->id) }}" method="POST" style="display:inline;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="badge badge-danger border-0 delete-button"><i class="fal fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                        {{-- <td class="align-middle" style="white-space: nowrap;">
                                            <form action="{{ route('owners.cancel-order', $resident->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge badge-danger border-0"><i
                                                        class="fal fa-trash-alt"></i></button>
                                            </form>
                                        </td> --}}
                                        
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>

                <div class="row justify-content-center p-5">
                    @if ($residents->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination rounded-active justify-content-center">
                                {{-- Nút về đầu --}}

                                <li class="page-item {{ $residents->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage(1)"
                                        wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')"><i
                                            class="far fa-angle-double-left"></i></a>
                                </li>

                                @php
                                    $totalPages = $residents->lastPage();
                                    $currentPage = $residents->currentPage();
                                    $visiblePages = 3; // Số trang hiển thị ở giữa
                                @endphp

                                {{-- Trang đầu --}}
                                <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                                    <a class="page-link hover-white" wire:click="gotoPage(1)"
                                        wire:loading.attr="disabled">1</a>
                                </li>

                                {{-- Dấu ba chấm đầu --}}
                                @if ($currentPage > $visiblePages)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                {{-- Các trang giữa --}}
                                @foreach (range(max(2, min($currentPage - 1, $totalPages - $visiblePages + 1)), min(max($currentPage + 1, $visiblePages), $totalPages - 1)) as $i)
                                    @if ($i > 1 && $i < $totalPages)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link hover-white"
                                                wire:click="gotoPage({{ $i }})"
                                                wire:loading.attr="disabled">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Dấu ba chấm cuối --}}
                                @if ($currentPage < $totalPages - ($visiblePages - 1))
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                {{-- Trang cuối --}}
                                @if ($totalPages > 1)
                                    <li class="page-item {{ $currentPage == $totalPages ? 'active' : '' }}">
                                        <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                            wire:loading.attr="disabled">{{ $totalPages }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ !$residents->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link hover-white"
                                        wire:click="gotoPage({{ $residents->lastPage() }})"
                                        wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')"><i
                                            class="far fa-angle-double-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', function() {
            const checkAll = document.getElementById('selectAll'); // Checkbox "Chọn tất cả"
            const deleteSelectedBtn = document.getElementById('deleteSelected');
            const childCheckboxes = document.querySelectorAll('.child-chk'); // Tất cả checkbox con

            // Sự kiện cho checkbox "Chọn tất cả"
            checkAll.addEventListener('change', function() {
                childCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    checkbox.dispatchEvent(new Event('change', {
                        'bubbles': true
                    }));
                });
                updateDeleteButtonState();
            });

            // Sự kiện cho từng checkbox con
            childCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Nếu một checkbox con không được chọn, bỏ chọn checkbox "Chọn tất cả"
                    if (!this.checked) {
                        checkAll.checked = false;
                    } else if (Array.from(childCheckboxes).every(chk => chk.checked)) {
                        // Nếu tất cả checkbox con được chọn, đánh dấu checkbox "Chọn tất cả"
                        checkAll.checked = true;
                    }
                    updateDeleteButtonState();
                });
            });

            // Sự kiện cho nút xóa
            deleteSelectedBtn.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedCheckboxes = document.querySelectorAll('.child-chk:checked');
                if (selectedCheckboxes.length === 0) {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Vui lòng chọn ít nhất một yêu cầu bảo trì để xóa',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Bạn sẽ không thể hoàn tác hành động này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, xóa!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const selectedIds = Array.from(selectedCheckboxes).map(checkbox => {
                            return checkbox.closest('tr').getAttribute('data-id');
                        });
                        @this.call('deleteSelectedJoinRoom', {
                            ids: selectedIds
                        });
                    }
                });
            });

            // Cập nhật trạng thái nút xóa
            function updateDeleteButtonState() {
                const selectedCount = document.querySelectorAll('.child-chk:checked').length;
                deleteSelectedBtn.disabled = selectedCount === 0;
            }

            // Gán sự kiện cho các checkbox con
            document.querySelectorAll('.child-chk').forEach(checkbox => {
                checkbox.addEventListener('change', updateDeleteButtonState);
            });

            updateDeleteButtonState(); // Cập nhật trạng thái nút xóa ban đầu

            // Sự kiện khi xóa thành công
            Livewire.on('maintenances-deleted', (data) => {
                console.log('Maintenances deleted event received:', data);
                Swal.fire({
                    title: 'Xóa Thành công!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            });

            // Sự kiện khi có lỗi
            Livewire.on('error', (data) => {
                Swal.fire({
                    title: 'Lỗi!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
   <script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Xác nhận xóa',
                text: "Bạn có chắc chắn muốn xóa không?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Có, xóa!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi yêu cầu AJAX
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ _method: 'DELETE' })
                    })
                    .then(response => {
                        return response.json(); // Chuyển đổi phản hồi thành JSON
                    })
                    .then(data => {
                        if (data.message) {
                            // Xử lý thành công
                            form.closest('tr').remove(); // Xóa dòng tương ứng
                            Swal.fire('Đã xóa!', data.message, 'success');
                        } else if (data.error) {
                            // Hiển thị thông báo lỗi
                            Swal.fire('Có lỗi xảy ra!', data.error, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        Swal.fire('Có lỗi xảy ra!', 'Vui lòng thử lại sau.', 'error');
                    });
                }
            });
        });
    });
</script>
</main>
