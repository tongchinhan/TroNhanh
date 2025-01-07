<div>
    {{-- Stop trying to control. --}}
    <main id="content" class="bg-gray-01">
        <div class="px-3 px-lg-6 px-xxl-13 py-5 py-lg-10 invoice-listing">
            <div class="mb-6" wire:ignore>
                <div class="row">
                    <div class="col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center">
                        <div class="d-flex form-group mb-0 align-items-center">
                            <label class="form-label fs-6 fw-bold mr-2 mb-0">Lọc:</label>
                            <select class="form-control selectpicker form-control-lg mr-2" wire:model.lazy="timeFilter"
                                data-style="bg-white btn-lg h-52 py-2 border">
                                <option value="" selected>Mặc định:</option>
                                <option value="1_day">Hôm qua</option>
                                <option value="7_day">7 ngày</option>
                                <option value="1_month">1 tháng</option>
                                <option value="3_month">3 tháng</option>
                                <option value="6_month">6 tháng</option>
                                <option value="1_year">1 năm</option>
                            </select>
                        </div>
                        <div class="align-self-center">
                            <a href="{{ route('owners.blog') }}" class="btn btn-primary btn-lg"
                                tabindex="0"><span>Thêm
                                    mới</span></a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3">
                        <div class="input-group input-group-lg bg-white mb-0 position-relative mr-2">
                            <input wire:model.lazy="search" wire:keydown.debounce.500ms="$refresh" type="text"
                                class="form-control bg-transparent border-1x" placeholder="Tìm kiếm..." aria-label=""
                                aria-describedby="basic-addon1">
                            <div class="input-group-append position-absolute pos-fixed-right-center">
                                <button class="btn bg-transparent border-0 text-gray lh-1" type="button">
                                    <i class="fal fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="align-self-center">
                            <button id="deleteSelected" class="btn btn-danger btn-lg" tabindex="0"
                                aria-controls="invoice-list" disabled><span>Xóa</span></button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="table-responsive custom-table-responsive">
                <table class="table table-hover table-sm bg-white border rounded-lg">
                    <thead class="thead-sm thead-black">
                        <tr role="row">
                            <th scope="col" class="px-6 py-3">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="py-3 text-nowrap text-center col-2">Ảnh</th>
                            <th class="py-3 text-nowrap text-center col-2">Tiêu đề</th>
                            <th class="py-3 text-nowrap text-center col-2">Ngày đăng</th>
                            <th class="py-3 text-nowrap text-center col-2">Ngày cập nhật</th>

                            <th class="py-3 text-nowrap text-center col-1">Lượt xem</th>


                            {{-- <th class="py-3 text-nowrap text-center col-2">Ngày xuất bản</th> --}}
                            <th class="no-sort py-3 text-nowrap text-center col-2">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($blogs->isEmpty())
                            <tr>
                                <td colspan="7">
                                    <p class="text-center">Không có blog nào.</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($blogs as $blog)
                                <tr role="row" data-id="{{ $blog->id }}"
                                    class="shadow-hover-xs-2 bg-hover-white">
                                    <td class="align-middle px-6">
                                        <input type="checkbox" class="control-input child-chk"
                                            data-id="{{ $blog->id }}">
                                    </td>
                                    <td class="align-middle d-md-table-cell text-nowrap p-4 text-center">
                                        <div class="mr-2 position-relative blog-image-container">
                                            <a href="{{ route('client.client-blog-detail', $blog->slug) }}">
                                                {{-- Giả sử $blog->image chứa ID của tệp trên Google Drive --}}
                                                @php
                                                    $imageIds = explode(',', $blog->image); // Tách các ID tệp nếu có nhiều tệp
                                                    $firstImageId = $imageIds[0] ?? null; // Lấy ID đầu tiên
                                                @endphp

                                                @if ($firstImageId)
                                                    <img src="https://drive.google.com/thumbnail?id={{ $firstImageId }}"
                                                        alt="{{ $blog->title }}"
                                                        class="img-fluid blog-image square-image">
                                                @else
                                                    <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                        alt="Default Image" class="img-fluid blog-image square-image">
                                                    {{-- Hình ảnh mặc định nếu không có ID --}}
                                                @endif
                                            </a>
                                        </div>

                                    </td>
                                    <td class="align-middle text-center" style="white-space: nowrap;">
                                        <div class="d-flex align-items-center">
                                            <div class="media-body">
                                                <a href="{{ route('client.client-blog-detail', $blog->slug) }}">
                                                    <span
                                                        class="text-dark hover-primary mb-1 font-size-md">{{ $blog->title }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center"style="white-space: nowrap;">

                                        {{ $blog->created_at->format('d-m-Y') }}

                                    </td>
                                    <td class="align-middle text-center"style="white-space: nowrap;">

                                        {{ $blog->updated_at->format('d-m-Y') }}

                                    </td>

                                    <td class="align-middle text-center"style="white-space: nowrap;">
                                        @if ($blog->view > 0)
                                            {{ $blog->view }}
                                        @else
                                            0
                                        @endif
                                    </td>

                                    {{-- <td class="align-middle ">
                                        <span class="text-success pr-1"><i class="fal fa-calendar"></i></span>
                                        {{ $blog->created_at->format('d-m-Y') }}
                                    </td> --}}
                                    <td class="align-middle text-center">
                                        <a href="{{ route('owners.sua-blog', ['id' => $blog->id]) }}"
                                            data-toggle="tooltip" title="Chỉnh sửa" class="btn btn-primary btn-sm mr-2">
                                            <i class="fal fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('owners.destroy-blog', $blog->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fal fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($blogs->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination rounded-active justify-content-center">
                        {{-- Nút về đầu --}}

                        <li class="page-item {{ $blogs->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link hover-white" wire:click="gotoPage(1)" wire:loading.attr="disabled"
                                rel="prev" aria-label="@lang('pagination.previous')"><i
                                    class="far fa-angle-double-left"></i></a>
                        </li>
                        @php
                            $totalPages = $blogs->lastPage();
                            $currentPage = $blogs->currentPage();
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


                        <li class="page-item {{ !$blogs->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link hover-white" wire:click="gotoPage({{ $blogs->lastPage() }})"
                                wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')"><i
                                    class="far fa-angle-double-right"></i></a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                if (!this.checked) {
                    checkAll.checked = false;
                } else if (Array.from(childCheckboxes).every(chk => chk.checked)) {
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
                    text: 'Vui lòng chọn ít nhất một blog để xóa.',
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
                confirmButtonText: 'Có!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    const selectedIds = Array.from(selectedCheckboxes).map(checkbox => {
                        return checkbox.closest('tr').getAttribute('data-id');
                    });
                    @this.call('deleteSelectedBlogs', {
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
        Livewire.on('blogs-deleted', (data) => {
            console.log('Blogs deleted event received:', data);
            Swal.fire({
                title: 'Thành công!',
                text: data[0].message || 'Đã xóa thành công.', // Hiển thị thông báo thành công
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
