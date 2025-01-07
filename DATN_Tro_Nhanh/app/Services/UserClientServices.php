<?php
// <!-- bên trong đây tạo ra các file tương ứng với các bảng để lấy dữ liệu  -->
// đây chỉ là file mẫu mọi người tự tạo ra các file khác ko dùng file này 
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use App\Models\Zone;

class UserClientServices
{
    /**
     * Lấy thông tin chi tiết của người dùng theo ID.
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    /**
     * Lấy danh sách người dùng có role = 2 với phân trang.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersByRole($role, $searchTerm = null, $limit, $province = null, $district = null, $village = null)
    {
        $query = User::where('role', $role)
            // ->leftJoin('rooms', 'users.id', '=', 'rooms.user_id')
            // ->leftJoin('comments', 'users.id', '=', 'comments.commented_user_id')
            ->select('users.*')
            // ->selectRaw('COUNT(DISTINCT rooms.id) as rooms_count')
            // ->selectRaw('AVG(comments.rating) as average_rating')
            // ->selectRaw('COUNT(DISTINCT comments.id) as review_count')
            // ->groupBy('users.id')
            ->orderBy('has_vip_badge', 'desc');
        // ->orderBy('average_rating', 'desc')
        // ->orderBy('review_count', 'desc')
        // ->orderBy('rooms_count', 'desc');
        // ->orderBy('users.created_at', 'desc');

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('users.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('users.email', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($province || $district || $village) {
            $query->where(function ($q) use ($province, $district, $village) {
                if ($province) {
                    $q->where('users.province', $province);
                }
                if ($district) {
                    $q->where('users.district', $district);
                }
                if ($village) {
                    $q->where('users.village', $village);
                }
            });
        }

        return $query->paginate($limit);
    }


public function getUsersByRoleNoLimit($role)
{
    $query = User::where('role', $role)
        ->leftJoin('zones', 'users.id', '=', 'zones.user_id')
        ->leftJoin('comment_user', 'users.id', '=', 'comment_user.commented_user_id')
        ->select('users.*')
        ->selectRaw('COUNT(DISTINCT zones.id) as zones_count')
        ->selectRaw('AVG(comment_user.rating) as average_rating')
        ->selectRaw('COUNT(DISTINCT comment_user.id) as review_count')
        ->groupBy('users.id')
        ->orderBy('has_vip_badge', 'desc')
        ->orderBy('average_rating', 'desc')
        ->orderBy('review_count', 'desc')
        ->orderBy('zones_count', 'desc')
        ->orderBy('users.created_at', 'desc');

   

    return $query->get();
}
    // public function getUsersByRole2($role, $searchTerm = null, $limit)
    // {
    //     // Khởi tạo query để lọc người dùng theo vai trò
    //     $query = User::where('role', $role);

    //     // Nếu có từ khóa tìm kiếm, thêm điều kiện tìm kiếm
    //     if ($searchTerm) {
    //         $query->where(function ($q) use ($searchTerm) {
    //             $q->where('name', 'like', '%' . $searchTerm . '%')
    //               ->orWhere('email', 'like', '%' . $searchTerm . '%');
    //         });
    //     }

    //     // Trả về kết quả phân trang
    //     return $query->paginate($limit);
    // }





    public function getUserBySlug($slug)
    {
        return User::where('slug', $slug)->first();
    }
    public function changePassword(UpdatePasswordRequest $request): void
    {
        $validated = $request->validated();

        // Cập nhật mật khẩu của người dùng hiện tại
        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);
    }

    public function getUnreadMessagesCount($userId)
    {
        return Message::whereHas('contact', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhere('contact_user_id', $userId);
        })
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
    public function getUserBalanceForAppProvider()
    {
        // Lấy user hiện tại
        $user = Auth::user();

        // Kiểm tra nếu user tồn tại và lấy balanceviết se
        if ($user) {
            return $user->balance; // Trả về số dư của người dùng
        }

        return '0'; // Trả về '0' nếu không có người dùng
    }

    public function getUniqueLocations()
    {
        try {
            $provinces = User::distinct()->whereNotNull('province')->pluck('province', 'province')->toArray();
            $districts = User::distinct()->whereNotNull('district')->select('province', 'district')->get()
                ->groupBy('province')
                ->map(function ($items) {
                    return $items->pluck('district')->toArray();
                })
                ->toArray();
            $villages = User::distinct()->whereNotNull('village')->select('district', 'village')->get()
                ->groupBy('district')
                ->map(function ($items) {
                    return $items->pluck('village')->toArray();
                })
                ->toArray();

            return [
                'provinces' => $provinces,
                'districts' => $districts,
                'villages' => $villages
            ];
        } catch (\Exception $e) {
            Log::error('Không thể lấy danh sách địa điểm: ' . $e->getMessage());
            return null;
        }
    }
    public function getUsersWithRoleZero($limit = 10)
    {
        return User::where('role', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }
    public function updateBalance($userId, $amount)
    {
        // Lấy người dùng theo ID
        $user = User::find($userId);

        if ($user) {
            // Kiểm tra xem số dư có đủ để trừ không
            if ($user->balance >= $amount) {
                // Cập nhật số dư mới
                $user->balance -= $amount; // Trừ số dư
                $user->save(); // Lưu thay đổi vào cơ sở dữ liệu

                return $user;  // Trả về true nếu cập nhật thành công
            } else {
                return false; // Trả về false nếu số dư không đủ
            }
        }

        return false; // Trả về false nếu không tìm thấy người dùng
    }
}
