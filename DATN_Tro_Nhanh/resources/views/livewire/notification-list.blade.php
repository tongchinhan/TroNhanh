<div>
    <div class="mb-6">
        <div class="row" wire:ignore>
            <div class="col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center">
                <div class="d-flex form-group mb-0 align-items-center ml-3">
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
                    <input type="text" wire:model.lazy="search" wire:keydown.debounce.300ms="$refresh"
                        class="form-control bg-transparent border-1x" placeholder="Tìm..." aria-label=""
                        aria-describedby="basic-addon1">
                    <div class="input-group-append position-absolute pos-fixed-right-center">
                        <button class="btn bg-transparent border-0 text-gray lh-1" type="button">
                            <i class="fal fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="align-self-center">
                    <button id="deleteSelected" class="btn btn-danger btn-lg" tabindex="0"
                        aria-controls="invoice-list"><span>Xóa</span></button>

                </div>
            </div>

        </div>

    </div>
    <div class="table-responsive">
        <table id="notification-list" class="table table-hover bg-white border rounded-lg">
            <thead>
                <tr role="row">
                    <th class="py-6">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th class="py-6" style="white-space:nowrap">Loại</th>
                    <th class="py-6" style="white-space:nowrap">Dữ liệu</th>
                    <!-- <th class="py-6">Trạng thái</th> -->
                    <th class="py-6" style="white-space:nowrap">Ngày tạo</th>
                    <th class=" py-6 " style="white-space:nowrap">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($notifications->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Không có dữ liệu</td>
                    </tr>
                @else
                    @foreach ($notifications as $notification)
                        <tr role="row">
                            <td class="align-middle">
                                <input type="checkbox" class="notification-checkbox" wire:model="selectedNotifications"
                                    value="{{ $notification->id }}">
                            </td>
                            <td class="align-middle" style="white-space:nowrap">{{ $notification->type }}</td>
                            <td class="align-middle" style="white-space:nowrap">
                                @if ($notification->blog)
                                    <a
                                        href="{{ route('owners.notification-update', ['slug' => $notification->blog->slug]) }}">
                                        {{ $notification->data }}
                                    </a>
                                @elseif ($notification->room)
                                    <a
                                        href="{{ route('owners.notification-update', ['slug' => $notification->room->slug]) }}">
                                        {{ $notification->data }}
                                    </a>
                                @else
                                    <span class="text-dark">{{ $notification->data }}</span>
                                @endif
                            </td>
                            <!-- <td class="align-middle">
                                <span class="badge badge-{{ $notification->status === 2 ? 'green' : 'red' }} text-capitalize">
                                    {{ $notification->status === 2 ? 'Đã xem' : 'Chưa xem' }}
                                </span>
                            </td> -->
                            <td class="align-middle" style="white-space:nowrap">
                                {{ $notification->created_at->format('d-m-Y') }}</td>
                            <td class="align-middle">
                                <a href="#" wire:click.prevent="deleteNotification({{ $notification->id }})"
                                    data-toggle="tooltip" title="Xóa"
                                    class="d-inline-block fs-18 text-muted hover-primary">
                                    <i class="fal fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- Phân trang -->
        @if ($notifications->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination rounded-active justify-content-center">
                    {{-- Nút về đầu --}}

                    <li class="page-item {{ $notifications->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link hover-white" wire:click="gotoPage(1)" wire:loading.attr="disabled"
                            rel="prev" aria-label="@lang('pagination.previous')"><i class="far fa-angle-double-left"></i></a>
                    </li>



                    @php
                        $totalPages = $notifications->lastPage();
                        $currentPage = $notifications->currentPage();
                        $visiblePages = 3; // Số trang hiển thị ở giữa
                    @endphp

                    {{-- Trang đầu --}}
                    <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                        <a class="page-link hover-white" wire:click="gotoPage(1)" wire:loading.attr="disabled">1</a>
                    </li>

                    {{-- Dấu ba chấm đầu --}}
                    @if ($currentPage > $visiblePages)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    {{-- Các trang giữa --}}
                    @foreach (range(max(2, min($currentPage - 1, $totalPages - $visiblePages + 1)), min(max($currentPage + 1, $visiblePages), $totalPages - 1)) as $i)
                        @if ($i > 1 && $i < $totalPages)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link hover-white" wire:click="gotoPage({{ $i }})"
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


                    <li class="page-item {{ !$notifications->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link hover-white" wire:click="gotoPage({{ $notifications->lastPage() }})"
                            wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')"><i
                                class="far fa-angle-double-right"></i></a>
                    </li>
                </ul>
            </nav>

        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        const checkboxes = document.querySelectorAll('.notification-checkbox');
        const selectAllCheckbox = document.getElementById('checkAll');
        const deleteSelectedBtn = document.getElementById('deleteSelected');

        function updateSelectAllState() {
            if (checkboxes.length === 0) {
                // Nếu không có checkbox nào, vô hiệu hóa nút "Chọn tất cả"
                if (selectAllCheckbox) selectAllCheckbox.disabled = true;
                return;
            }

            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.disabled = false;
            }
            updateDeleteButtonVisibility();
        }

        function updateDeleteButtonVisibility() {
            // deleteSelectedBtn.style.display = Array.from(checkboxes).some(checkbox => checkbox.checked) ?
            //     'block' : 'none';
            deleteSelectedBtn.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                updateSelectAllState();
                @this.set('selectedNotifications', Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value)
                );
            });
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', () => {
                const isChecked = selectAllCheckbox.checked;
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateDeleteButtonVisibility();
                @this.set('selectedNotifications', isChecked ? Array.from(checkboxes).map(cb => cb
                    .value) : []);
            });
        }

        // Sự kiện cho nút xóa
        deleteSelectedBtn.addEventListener('click', () => {
            const selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Vui lòng chọn ít nhất một thông báo để xóa',
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
                    @this.call('deleteSelectedNotifications',
                        selectedIds); // Gọi hàm xóa với các ID đã chọn
                }
            });
        });

        // Khởi tạo trạng thái ban đầu
        updateSelectAllState();
    });

    // Xử lý thông báo sau khi xóa thành công
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('notifications-deleted', (event) => {
            Swal.fire({
                title: 'Thành công!',
                text: 'Xóa thông báo thành công',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        });
    });
</script>
