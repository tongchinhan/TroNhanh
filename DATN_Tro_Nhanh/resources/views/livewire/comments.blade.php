<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div>
        @if ($comments->isEmpty())
            <div class="col-12">
                <p class="text-center">Không có đánh giá nào!</p>
            </div>
        @else
            @foreach ($comments as $comment)
                <div class="media border-top pt-7 pb-6 d-sm-flex d-block text-sm-left text-center">
                    <img src="{{ $comment->user->image ? asset('assets/images/' . $comment->user->image) : asset('assets/images/review-07.jpg') }}"
                        alt="{{ $comment->user->name }}" class="mr-sm-8 mb-4 mb-sm-0 custom-avatar">

                    <div class="media-body">
                        <div class="row mb-1 align-items-center">
                            <div class="col-sm-6 mb-2 mb-sm-0">
                                <h4 class="mb-0 text-heading fs-14">{{ $comment->user->name }}</h4>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-inline d-flex justify-content-sm-end justify-content-center mb-0">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="list-inline-item mr-1">
                                            <span class="text-warning fs-12 lh-2">
                                                <i class="fas fa-star{{ $i <= $comment->rating ? '' : '-o' }}"></i>
                                            </span>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                        <p class="mb-3 pr-xl-17">{{ $comment->content }}</p>
                        <div class="d-flex justify-content-sm-start justify-content-center">
                            <p class="mb-0 text-muted fs-13 lh-1">
                                {{ $comment->created_at->format('d/m/Y h:i A') }}
                                {{-- <a href="#"
                                    class="mb-0 text-heading border-left border-dark hover-primary lh-1 ml-2 pl-2">Trả
                                    lời</a> --}}
                                @if (Auth::id() == $comment->user_id)
                                    <a href="#"
                                        class="mb-0 text-danger border-left border-dark hover-primary lh-1 ml-2 pl-2"
                                        wire:click.prevent="deleteComment({{ $comment->id }})">
                                        Xóa
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if ($comments->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination rounded-active justify-content-center">
                @php
                    $totalPages = $comments->lastPage(); // Tổng số trang
                    $currentPage = $comments->currentPage(); // Trang hiện tại
                    $visiblePages = 3; // Số trang giữa cần hiển thị
                @endphp
    
                {{-- Liên kết đến Trang đầu --}} 
                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a class="page-link hover-white" wire:click="gotoPage(1)" wire:loading.attr="disabled" aria-label="First">
                        <span aria-hidden="true">«</span> {{-- Dấu kép nhỏ hơn cho trang đầu tiên --}}
                    </a>
                </li>
    
                {{-- Liên kết đến Trang trước --}}
                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a class="page-link hover-white" wire:click="gotoPage({{ $currentPage - 1 }})" wire:loading.attr="disabled" aria-label="Previous">
                        <span aria-hidden="true">&lt;</span> {{-- Dấu nhỏ hơn cho trang trước --}}
                    </a>
                </li>
    
                {{-- Trang đầu tiên --}}
                <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                    <a class="page-link hover-white" wire:click="gotoPage(1)" wire:loading.attr="disabled">1</a>
                </li>
    
                {{-- Hiển thị Dấu 3 chấm nếu cần trước các trang giữa --}}
                @if ($currentPage > $visiblePages + 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
    
                {{-- Hiển thị các trang giữa --}}
                @foreach (range(max(2, min($currentPage - 1, $totalPages - $visiblePages + 1)), min(max($currentPage + 1, 2), $totalPages - 1)) as $i)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link hover-white" wire:click="gotoPage({{ $i }})" wire:loading.attr="disabled">{{ $i }}</a>
                    </li>
                @endforeach
    
                {{-- Hiển thị Dấu 3 chấm nếu cần sau các trang giữa --}}
                @if ($currentPage < $totalPages - $visiblePages)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
    
                {{-- Trang cuối cùng --}}
                @if ($totalPages > 1)
                    <li class="page-item {{ $currentPage == $totalPages ? 'active' : '' }}">
                        <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})" wire:loading.attr="disabled">{{ $totalPages }}</a>
                    </li>
                @endif
    
                {{-- Liên kết đến Trang tiếp theo --}}
                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                    <a class="page-link hover-white" wire:click="gotoPage({{ $currentPage + 1 }})" wire:loading.attr="disabled" aria-label="Next">
                        <span aria-hidden="true">&gt;</span> {{-- Dấu lớn hơn cho trang tiếp theo --}}
                    </a>
                </li>
    
                {{-- Liên kết đến Trang cuối --}}
                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                    <a class="page-link hover-white" wire:click="gotoPage({{ $totalPages }})" wire:loading.attr="disabled" aria-label="Last">
                        <span aria-hidden="true">»</span> {{-- Dấu kép lớn hơn cho trang cuối --}}
                    </a>
                </li>
            </ul>
        </nav>
    @endif
    



    </div>





</div>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('showAlert', (event) => {
            Swal.fire({
                icon: event[0].type,
                title: event[0].title,
                text: event[0].text,
            });
        });
    });
</script>
