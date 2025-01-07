<div>
    {{-- Do your work, then step back. --}}
    <main id="content" class="bg-gray-01">
        <div class="px-3 px-lg-6 px-xxl-13 py-5 invoice-listing">
            <div class="mb-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center">
                        <div wire:ignore class="d-flex form-group mb-0 align-items-center ml-3">
                            <label class="form-label fs-6 fw-bold mr-2 mb-0">Lọc:</label>
                            <select wire:model.lazy="timeFilter" id="timeFilter"
                                class="form-control form-control-lg selectpicker"
                                data-style="bg-white btn-lg h-52 py-2 border">
                                <option value="" selected>Thời Gian:</option>
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
                            <input type="text" wire:model="search" wire:keydown.debounce.300ms="$refresh"
                                class="form-control bg-transparent border-1x" name="search" placeholder="Tìm kiếm...">
                            <div class="input-group-append position-absolute pos-fixed-right-center">
                                <button class="btn bg-transparent border-0 text-gray lh-1" type="button"><i
                                        class="fal fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="notification-list" class="table table-hover bg-white border rounded-lg">
                <thead>
                    <tr role="row">
                       
                        <th class="py-6" style="white-space: nowrap;">Hình ảnh</th>

                        <th class="py-6" style="white-space: nowrap;">Tên</th>
                        <th class="py-6" style="white-space: nowrap;">Chức năng</th>
                        <th class="py-6 text-center" style="white-space: nowrap;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($myFollowings->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">Danh sách trống</td>
                        </tr>
                    @else
                        @foreach ($myFollowings as $item)
                            <tr role="row">
                                
                                <td class="align-middle pt-6 pb-4 px-6" style="white-space: nowrap;">
                                    <div class="media d-flex align-items-center">
                                        <div class="w-120px mr-4 position-relative">
                                            <a href="{{ route('client.client-agent-detail', $item->personBeingFollowed->slug) }}">
                                                @if ($item->personBeingFollowed->image)
                                                    <img src="{{ asset('assets/images/' . $item->personBeingFollowed->image) }}"
                                                        alt="{{ $item->personBeingFollowed->image }}"
                                                        class="img-fluid rounded-image avatar ">
                                                @else
                                                    <p>Chưa có ảnh</p>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                               
                                </td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    {{ $item->personBeingFollowed->name }}
                                </td>
                                <td class="align-middle" style="white-space: nowrap;">
                                    @if ($item->personBeingFollowed->role == '2')
                                        <span>Người đưa tin</span>
                                    @elseif ($item->personBeingFollowed->role == '0')
                                        <span>Người quản trị</span>
                                    @else
                                        <span>Người dùng</span>
                                    @endif

                                </td>

                                <td class="align-middle text-center" style="white-space: nowrap;">
                                    <button wire:click="xoaNguoiTheoDoi({{ $item->id }})" data-toggle="tooltip"
                                        title="Xóa"
                                        class="btn btn-link p-0 d-inline-block fs-18 text-muted hover-primary">
                                        <i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- Phân trang 1-->
            @if ($myFollowings->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm rounded-active justify-content-center">
                        {{-- Liên kết Trang Đầu --}}
                        <li class="page-item {{ $myFollowings->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link hover-white" wire:click="gotoPage(1)" wire:loading.attr="disabled"
                                rel="first" aria-label="@lang('pagination.first')"><i
                                    class="far fa-angle-double-left"></i></a>
                        </li>

                        {{-- Liên kết Trang Trước --}}
                        <li class="page-item {{ $myFollowings->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link hover-white" wire:click="previousPage" wire:loading.attr="disabled"
                                rel="prev" aria-label="@lang('pagination.previous')"><i class="far fa-angle-left"></i></a>
                        </li>

                        @php
                            $totalPages = $myFollowings->lastPage();
                            $currentPage = $myFollowings->currentPage();
                            $visiblePages = 2; // Số trang hiển thị ở giữa
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

                        {{-- Liên kết Trang Tiếp --}}
                        <li class="page-item {{ !$myFollowings->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link hover-white" wire:click="nextPage" wire:loading.attr="disabled"
                                rel="next" aria-label="@lang('pagination.next')"><i class="far fa-angle-right"></i></a>
                        </li>

                        {{-- Liên kết Trang Cuối --}}
                        <li class="page-item {{ !$myFollowings->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})"
                                wire:loading.attr="disabled" rel="last" aria-label="@lang('pagination.last')"><i
                                    class="far fa-angle-double-right"></i></a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
</div>
</main>
</div>
