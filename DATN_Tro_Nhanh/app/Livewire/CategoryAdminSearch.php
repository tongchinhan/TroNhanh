<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Carbon\Carbon;

class CategoryAdminSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $timeFilter = ''; // Mặc định là không lọc
    public $orderBy = 'created_at'; // Mặc định sắp xếp theo ngày tạo mới nhất
    public $orderAsc = false; // Giảm dần
    public $perPage = 10;

    public function updatingSearch()
    {
        // Reset pagination khi tìm kiếm
        $this->resetPage();
    }

    public function render()
    {
        $query = Category::query();
        // Lọc theo khoảng thời gian
        if ($this->timeFilter) {
            $now = Carbon::now();

            switch ($this->timeFilter) {
                case "1_day":
                    $startDate = $now->subDays(1);
                    break;
                case '7_day':
                    $startDate = $now->subDays(7);
                    break;
                case '3_month':
                    $startDate = $now->subMonths(3);
                    break;
                case '6_month':
                    $startDate = $now->subMonths(6);
                    break;
                case '1_year':
                    $startDate = $now->subYear();
                    break;
                default:
                    $startDate = null;
            }

            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Sắp xếp theo ngày tạo mới nhất mặc định
        $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

        $categories = $query->paginate($this->perPage);

        return view('livewire.category-admin-search', [
            'categories' => $categories
        ]);
    }
}
