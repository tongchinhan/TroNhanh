<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Category;
use App\Models\Zone;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class RoomClientServices
{
    // viết các hàm lấy giá trị của bản đó 
    private const trangthaiphong = 2;
    private const status = 2;
    private const HIEN_THI = 2;
    private const NOI_O_LY_TUONG = 1;
    private const DUOC_QUAN_TAM = 2;
    private const VI_TRI_GOI_KICH_HOAT = 1;
    private const TRANG_THAI_VIP_HIEN_THI = 1;
    private const SO_LUONG_HIEN_THI = 5;
    private const KHU_TRO_HA_NOI = 'Thành phố Hà Nội';
    private const KHU_TRO_CAN_THO = 'Thành phố Cần Thơ';
    // // ----------------------------------------------------------------Sắp Theo VIP
    // public function getAllRoom(int $perPage = 10, $type = null, $searchTerm = null, $province = null, $district = null, $village = null, $category = null, $features = null)
    // {
    //     try {
    //         $query = Room::join('users', 'rooms.user_id', '=', 'users.id')
    //             ->where('rooms.status', self::status)
    //             ->withCount('images')
    //             ->select('rooms.*')
    //             ->orderByDesc('rooms.created_at');

    //         // Nếu có loại phòng, thêm điều kiện vào truy vấn
    //         if ($type) {
    //             $query->whereHas('category', function ($q) use ($type) {
    //                 $q->where('name', $type); // Lọc theo tên loại phòng trong bảng category
    //             });
    //         }

    //         if ($category) {
    //             $query->where('category_id', $category); // Thêm điều kiện lọc theo category
    //         }

    //         if ($searchTerm) {
    //             $query->where(function ($q) use ($searchTerm) {
    //                 $q->where('rooms.title', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('rooms.description', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('rooms.address', 'like', '%' . $searchTerm . '%');
    //             });
    //         }

    //         // Nếu có tỉnh, huyện, xã, thêm điều kiện vào truy vấn
    //         if ($province) {
    //             $query->where('rooms.province', $province);
    //         }
    //         if ($district) {
    //             $query->where('rooms.district', $district);
    //         }
    //         if ($village) {
    //             $query->where('rooms.village', $village);
    //         }

    //         if ($category) {
    //             Log::info('Applying category filter: ' . $category); // Thêm log để kiểm tra
    //             $query->where('rooms.category_id', $category);
    //         }

    //         // Nếu có tiện ích, thêm điều kiện vào truy vấn
    //         if (!empty($features)) { // Kiểm tra nếu $features không rỗng
    //             $query->whereHas('utilities', function ($q) use ($features) {
    //                 foreach ($features as $feature) {
    //                     if ($feature == 'bathroom') {
    //                         $q->where('bathrooms', '>', 0); // Kiểm tra nếu bathrooms > 0
    //                     } elseif ($feature == 'wifi') {
    //                         $q->where('wifi', '>', 0); // Kiểm tra nếu wifi > 0
    //                     } elseif ($feature == 'air_conditioning') {
    //                         $q->where('air_conditioning', '>', 0); // Kiểm tra nếu air_conditioning > 0
    //                     } elseif ($feature == 'garage') {
    //                         $q->where('garage', '>', 0); // Kiểm tra nếu garage > 0
    //                     }
    //                 }
    //             });
    //         }
    //         $result = $query->paginate($perPage);
    //         Log::info('SQL Query: ' . $query->toSql());
    //         Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
    //         return $result;
    //     } catch (Exception $e) {
    //         Log::error('Error in getAllRoom: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    // // Thêm phương thức mới để lấy danh sách categories
    // public function getCategories()
    // {
    //     return Category::whereHas('rooms') // Ensure the category has related rooms
    //         ->select('id', 'name')
    //         ->get();
    // }
    // // ----------------------------------------------------------------Bổ sung đánh giá
    // // public function getAllRoom(int $perPage = 10, $searchTerm = null, $province = null, $district = null, $village = null)
    // // {
    // //     try {
    // //         $query = Room::join('users', 'rooms.user_id', '=', 'users.id') // Join bảng rooms và users
    // //             ->leftJoin('comments', 'users.id', '=', 'comments.user_id') // Join với bảng comments để lấy rating
    // //             ->where('rooms.status', self::status)
    // //             ->withCount('images') // Đếm số lượng ảnh liên quan đến mỗi phòng
    // //             ->select('rooms.*') // Chọn tất cả các cột từ bảng rooms
    // //             ->selectRaw('AVG(comments.rating) as user_rating') // Lấy trung bình rating của người dùng
    // //             ->groupBy('rooms.id', 'users.has_vip_badge', 'users.id') // Nhóm theo id phòng và người dùng
    // //             ->orderBy('users.has_vip_badge', 'desc') // Ưu tiên phòng của người dùng có huy hiệu VIP
    // //             ->orderByDesc('user_rating') // Sắp xếp theo đánh giá từ cao xuống thấp
    // //             ->orderByDesc('rooms.created_at'); // Sắp xếp theo ngày tạo từ mới nhất đến cũ nhất

    // //         // Nếu có từ khóa tìm kiếm, thêm điều kiện vào truy vấn
    // //         if ($searchTerm) {
    // //             $query->where(function ($q) use ($searchTerm) {
    // //                 $q->where('rooms.title', 'like', '%' . $searchTerm . '%')
    // //                     ->orWhere('rooms.description', 'like', '%' . $searchTerm . '%')
    // //                     ->orWhere('rooms.address', 'like', '%' . $searchTerm . '%');
    // //             });
    // //         }

    // //         // Nếu có tỉnh, huyện, xã, thêm điều kiện vào truy vấn
    // //         if ($province) {
    // //             $query->where('rooms.province', $province);
    // //         }
    // //         if ($district) {
    // //             $query->where('rooms.district', $district);
    // //         }
    // //         if ($village) {
    // //             $query->where('rooms.village', $village);
    // //         }

    // //         return $query->paginate($perPage);
    // //     } catch (\Exception $e) {
    // //         return null;
    // //     }
    // // }
    // // Lấy 5 phòng mới nhất
    // // public function getRoomWhere()
    // // {
    // //     $rooms = Room::orderBy('expiration_date', 'desc') // Sắp xếp theo expiration_date
    // //         ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
    // //         ->orderBy('view', 'desc') // Sắp xếp theo lượt xem cao nhất
    // //         ->take(5) // Lấy 5 phòng
    // //         ->get();
    // //     return $rooms; // Trả về danh sách phòng    
    // // }
    // public function getRoomWhere()
    // {
    //     $rooms = Room::query()
    //         ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
    //         // ->orderBy('view', 'desc') // Sắp xếp theo lượt xem cao nhất
    //         ->take(5) // Lấy 5 phòng
    //         ->get();

    //     return $rooms; // Trả về danh sách phòng    
    // }
    // public function RoomClient()
    // {
    //     $rooms = Room::orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
    //         // ->orderBy('created_at', 'desc') // Sắp xếp theo lượt xem cao nhất
    //         ->take(5) // Lấy 5 phòng
    //         ->get();

    //     return $rooms; // Trả về danh sách phòng    
    // }

    // public function incrementViewCount($roomId)
    // {
    //     // Kiểm tra xem cookie đã tồn tại chưa
    //     if (!request()->cookie('viewed_property_' . $roomId)) {
    //         // Tìm phòng theo ID
    //         $room = Room::find($roomId);

    //         if ($room) {
    //             // Tăng số lượt xem
    //             $room->increment('view');

    //             // Đặt cookie cho 2 giờ
    //             Cookie::queue('viewed_property_' . $roomId, true, 120);
    //         }
    //     }
    // }

    // // Lấy phòng theo slug
    // public function getSlugRoom($slug)
    // {
    //     try {
    //         $room = Room::where('slug', $slug)->first();
    //         return $room;
    //     } catch (\Exception $e) {
    //         return null;
    //     }
    // }

    // // Thêm phòng vào danh sách yêu thích
    // // public function addFavourite($userId, $roomId)
    // // {
    // //     // Kiểm tra xem phòng đã có trong danh sách yêu thích chưa
    // //     $existingFavourite = Favourite::where('user_id', $userId)
    // //         ->where('room_id', $roomId)
    // //         ->first();

    // //     if ($existingFavourite) {
    // //         return response()->json([
    // //             'success' => false,
    // //             'message' => 'Phòng này đã có trong danh sách yêu thích'
    // //         ]);
    // //     }

    // //     // Thêm mới vào danh sách yêu thích
    // //     Favourite::create([
    // //         'user_id' => $userId,
    // //         'room_id' => $roomId,
    // //     ]);

    // //     return response()->json([
    // //         'success' => true,
    // //         'message' => 'Thêm vào danh sách yêu thích thành công'
    // //     ]);
    // // }
    // public function addFavourite($slug)
    // {
    //     $room = Room::where('slug', $slug)->firstOrFail();
    //     $user = auth()->user();

    //     if ($user->favorites()->where('room_id', $room->id)->exists()) {
    //         $user->favorites()->detach($room->id);
    //         $status = 'removed';
    //     } else {
    //         $user->favorites()->attach($room->id);
    //         $status = 'added';
    //     }

    //     $favoriteCount = $user->favorites()->count();

    //     return response()->json([
    //         'status' => $status,
    //         'favoriteCount' => $favoriteCount
    //     ]);
    // }
    // public function getRoomCount($userId = null)
    // {
    //     // Nếu userId không có hoặc NULL sẽ auth()->id();
    //     $userId = $userId ?? auth()->id();
    //     return Room::where('user_id', $userId)->count();
    // }

    // public function getRoomClient($province, $currentRoomId)
    // {
    //     return Room::where('status', self::trangthaiphong)
    //         ->where('province', $province) // Thay 'province' bằng 'province_id' nếu cần
    //         ->where('id', '<>', $currentRoomId)
    //         ->withCount('images')
    //         ->get();
    // }

    // public function getUniqueLocations()
    // {
    //     try {
    //         $provinces = Room::distinct()->whereNotNull('province')->pluck('province', 'province')->toArray();
    //         $districts = Room::distinct()->whereNotNull('district')->select('province', 'district')->get()
    //             ->groupBy('province')
    //             ->map(function ($items) {
    //                 return $items->pluck('district')->toArray();
    //             })
    //             ->toArray();
    //         $villages = Room::distinct()->whereNotNull('village')->select('district', 'village')->get()
    //             ->groupBy('district')
    //             ->map(function ($items) {
    //                 return $items->pluck('village')->toArray();
    //             })
    //             ->toArray();

    //         return [
    //             'provinces' => $provinces,
    //             'districts' => $districts,
    //             'villages' => $villages
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error('Không thể lấy danh sách địa điểm: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    // public function getAllRoomInCategory(int $perPage = 10,  $type = null, $searchTerm = null, $province = null, $district = null, $village = null, $category = null)
    // {
    //     try {
    //         $query = Room::join('users', 'rooms.user_id', '=', 'users.id')
    //             ->leftJoin('images', 'rooms.id', '=', 'images.room_id') // Thêm join với bảng images
    //             ->where('rooms.status', self::status)
    //             ->withCount('images')
    //             ->select('rooms.*', 'images.filename as image_url') // Lấy thêm trường hình ảnh
    //             ->orderByDesc('rooms.created_at');
    //         // Nếu có loại phòng, thêm điều kiện vào truy vấn
    //         if ($type) {
    //             $query->whereHas('category', function ($q) use ($type) {
    //                 $q->where('name', $type); // Lọc theo tên loại phòng trong bảng category
    //             });
    //         }

    //         if ($searchTerm) {
    //             $query->where(function ($q) use ($searchTerm) {
    //                 $q->where('rooms.title', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('rooms.description', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('rooms.address', 'like', '%' . $searchTerm . '%');
    //             });
    //         }


    //         // Nếu có tỉnh, huyện, xã, thêm điều kiện vào truy vấn
    //         if ($province) {
    //             $query->where('rooms.province', $province);
    //         }
    //         if ($district) {
    //             $query->where('rooms.district', $district);
    //         }
    //         if ($village) {
    //             $query->where('rooms.village', $village);
    //         }

    //         if ($category) {
    //             Log::info('Applying category filter: ' . $category); // Thêm log để kiểm tra
    //             $query->where('rooms.category_id', $category);
    //         }

    //         $result = $query->get();
    //         Log::info('SQL Query: ' . $query->toSql());
    //         Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
    //         return $result;
    //     } catch (Exception $e) {
    //         Log::error('Error in getAllRoom: ' . $e->getMessage());
    //         return null;
    //     }
    // }


    // // public function checkAndUpdateExpiredRooms()
    // // {
    // //     // Lấy ngày hiện tại
    // //     $currentDate = Carbon::now();

    // //     // Tìm các phòng có expiration_date nhỏ hơn ngày hiện tại
    // //     $expiredRooms = Room::where('expiration_date', '<=', $currentDate)->get();

    // //     $updatedCount = 0;

    // //     if ($expiredRooms->isNotEmpty()) {
    // //         foreach ($expiredRooms as $room) {
    // //             // Cập nhật expiration_date thành null cho các phòng hết hạn
    // //             $room->expiration_date = null;
    // //             $room->save();

    // //             $updatedCount++;
    // //         }
    // //     }

    // //     return $updatedCount; // Trả về số lượng phòng đã được cập nhật
    // // }
    // public function checkAndUpdateExpiredRooms()
    // {
    //     // Lấy ngày hiện tại
    //     $currentDate = Carbon::now();

    //     // Tìm các phòng có thời hạn (nếu có) nhỏ hơn ngày hiện tại
    //     $expiredRooms = Room::where(function ($query) use ($currentDate) {
    //         $query->where('created_at', '<=', $currentDate->subDays(30))
    //             ->orWhereNull('created_at');
    //     })->get();

    //     $updatedCount = 0;

    //     if ($expiredRooms->isNotEmpty()) {
    //         foreach ($expiredRooms as $room) {
    //             // Cập nhật trạng thái hoặc thực hiện các hành động cần thiết cho phòng hết hạn
    //             // Ví dụ: $room->status = 'expired';
    //             $room->save();

    //             $updatedCount++;
    //         }
    //     }

    //     return $updatedCount; // Trả về số lượng phòng đã được cập nhật
    // }
    // public function getAllRoomAPI(int $perPage = 10, $type = null, $searchTerm = null, $province = null, $district = null, $village = null, $category = null, $features = null)
    // {
    //     try {
    //         $query = Room::join('users', 'rooms.user_id', '=', 'users.id')
    //             ->leftJoin('images', 'rooms.id', '=', 'images.room_id')
    //             ->where('rooms.status', self::status)
    //             ->withCount('images')
    //             ->select('rooms.*', DB::raw('MIN(images.filename) as image_url'))
    //             ->groupBy('rooms.id')
    //             ->orderByDesc('rooms.created_at');

    //         // Thêm điều kiện lọc
    //         if ($type) {
    //             $query->whereHas('category', function ($q) use ($type) {
    //                 $q->where('name', $type);
    //             });
    //         }

    //         if ($searchTerm) {
    //             $query->where(function ($q) use ($searchTerm) {
    //                 $q->where('rooms.title', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('rooms.description', 'like', '%' . $searchTerm . '%')
    //                     ->orWhere('rooms.address', 'like', '%' . $searchTerm . '%');
    //             });
    //         }

    //         if ($province) {
    //             $query->where('rooms.province', $province);
    //         }
    //         if ($district) {
    //             $query->where('rooms.district', $district);
    //         }
    //         if ($village) {
    //             $query->where('rooms.village', $village);
    //         }
    //         if ($category) {
    //             Log::info('Applying category filter: ' . $category);
    //             $query->where('rooms.category_id', $category);
    //         }

    //         if (!empty($features)) {
    //             $query->where(function ($q) use ($features) {
    //                 foreach ($features as $feature) {
    //                     $q->orWhere($feature, 2);
    //                 }
    //             });
    //         }

    //         $result = $query->get();
    //         Log::info('SQL Query: ' . $query->toSql());
    //         Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
    //         return $result;
    //     } catch (Exception $e) {
    //         Log::error('Error in getAllRoom: ' . $e->getMessage());
    //         return null;
    //     }
    // }
    // // Phòng nổi bật
    // // public function getPopularRooms($limit = 3)
    // // {
    // //     return Room::with('images')
    // //         ->where('status', self::status)
    // //         ->orderBy('view', 'desc')
    // //         ->take($limit)
    // //         ->get();
    // // }
    // public function getPopularRooms($limit = 3)
    // {
    //     $currentDate = Carbon::now();

    //     return Room::with('images')
    //         ->where('status', self::status)
    //         ->where(function ($query) use ($currentDate) {
    //             $query->where('expiration_date', '>', $currentDate)
    //                 ->orWhereNull('expiration_date');
    //         })
    //         ->orderByRaw('CASE 
    //             WHEN expiration_date > ? THEN 0 
    //             ELSE 1 
    //         END', [$currentDate])
    //         ->orderByRaw('CASE 
    //             WHEN expiration_date > ? THEN view 
    //             ELSE 0 
    //         END DESC', [$currentDate])
    //         ->orderBy('view', 'desc')
    //         ->take($limit)
    //         ->get();
    // }
    // public function getRoomImages($roomId)
    // {
    //     try {
    //         $room = Room::findOrFail($roomId);
    //         return $room->images;
    //     } catch (\Exception $e) {
    //         Log::error('Error in getRoomImages: ' . $e->getMessage());
    //         return [];
    //     }
    // }

    // public function getRoomWhere()
    // {
    //     return Zone::with('rooms') // Thêm liên kết với bảng rooms
    //         ->orderBy('created_at', 'desc')
    //         ->take(5)
    //         ->get();
    // }

    // public function RoomClient()
    // {
    //     return Zone::with('rooms') // Thêm liên kết với bảng rooms
    //         ->orderBy('created_at', 'desc')
    //         ->take(5)
    //         ->get();
    // // }
    // Nơi ở lý tưởng
    // public function getRoomWhere()
    // {
    //     return Zone::with('rooms') // Tải trước mối quan hệ rooms
    //         ->join('users', 'zones.user_id', '=', 'users.id')
    //         ->where('zones.status', self::HIEN_THI)
    //         ->select('zones.*')
    //         ->orderBy('zones.created_at', 'desc')
    //         ->take(5)
    //         ->get();
    // }
    // public function getRoomWhere()
    // {
    //     $currentDate = Carbon::now();

    //     return Zone::with(['rooms', 'vipZonePositions.location'])
    //         ->join('users', 'zones.user_id', '=', 'users.id')
    //         ->join('vip_zone_positions', 'zones.id', '=', 'vip_zone_positions.zone_id')
    //         ->join('locations', 'vip_zone_positions.location_id', '=', 'locations.id')
    //         ->where('zones.status', self::HIEN_THI)
    //         ->where('locations.type_vip', self::NOI_O_LY_TUONG)
    //         ->where('locations.status', self::VI_TRI_GOI_KICH_HOAT)
    //         ->where('vip_zone_positions.status', self::TRANG_THAI_VIP_HIEN_THI)
    //         ->where('vip_zone_positions.end_date', '>', $currentDate)
    //         ->select('zones.*', 'locations.name as location_name', 'vip_zone_positions.end_date')
    //         ->orderBy('vip_zone_positions.created_at', 'desc')
    //         ->take(5)
    //         ->get();
    // }
    public function getRoomWhere()
    {
        $currentDate = Carbon::now();

        $vipZones = Zone::with(['rooms', 'vipZonePositions.location'])
            ->join('users', 'zones.user_id', '=', 'users.id')
            ->join('vip_zone_positions', 'zones.id', '=', 'vip_zone_positions.zone_id')
            ->join('locations', 'vip_zone_positions.location_id', '=', 'locations.id')
            ->where('zones.status', self::HIEN_THI)
            ->where('locations.type_vip', self::NOI_O_LY_TUONG)
            ->where('locations.status', self::VI_TRI_GOI_KICH_HOAT)
            ->where('vip_zone_positions.status', self::TRANG_THAI_VIP_HIEN_THI)
            ->where('vip_zone_positions.end_date', '>', $currentDate)
            ->select('zones.*', 'locations.name as location_name', 'vip_zone_positions.end_date')
            ->orderBy('vip_zone_positions.created_at', 'desc')
            ->take(5)
            ->get();

        if ($vipZones->isEmpty()) {
            // Nếu không có zone VIP, lấy các zone có view cao nhất
            return Zone::with('rooms')
                ->where('status', self::HIEN_THI)
                ->orderBy('view', 'desc')
                ->take(self::SO_LUONG_HIEN_THI)
                ->get();
        }

        return $vipZones;
    }
    //Khu tro Ha Noi
    public function getApprovedZonesInHanoi()
    {
        $approvedZones = Zone::with('rooms')
            ->where('status', self::HIEN_THI) // Ensure the zone status is 2 (approved)
            ->where('address', 'like', '%Thành Phố Hà Nội%') // Address contains "Thành Phố Hà Nội"
            ->orderBy('created_at', 'desc') // Order by the most recent
            ->take(self::SO_LUONG_HIEN_THI) // Limit the number of results
            ->get();
    
        if ($approvedZones->isEmpty()) {
            // If no approved zones in HCM, return an empty collection or handle as needed
            return collect();
        }
    
        return $approvedZones;
    }
    //Khu tro Ho Chi Minh
    public function getApprovedZonesInHCM()
    {
        $approvedZones = Zone::with('rooms')
            ->where('status', self::HIEN_THI) // Ensure the zone status is 2 (approved)
            ->where('address', 'like', '%Thành Phố Hồ Chí Minh%') // Address contains "Thành Phố Hồ Chí Minh"
            ->orderBy('created_at', 'desc') // Order by the most recent
            ->take(self::SO_LUONG_HIEN_THI) // Limit the number of results
            ->get();
    
        if ($approvedZones->isEmpty()) {
            // If no approved zones in HCM, return an empty collection or handle as needed
            return collect();
        }
    
        return $approvedZones;
    }
   
    //Khu tro Can Tho
    public function getApprovedZonesInCanTho()
    {
        $approvedZones = Zone::with('rooms')
            ->where('status', self::HIEN_THI) // Ensure the zone status is 2 (approved)
            ->where('address', 'like', '%Thành Phố Cần Thơ%') // Address contains "Thành Phố Cần Thơ"
            ->orderBy('created_at', 'desc') // Order by the most recent
            ->take(self::SO_LUONG_HIEN_THI) // Limit the number of results
            ->get();
    
        if ($approvedZones->isEmpty()) {
            // If no approved zones in HCM, return an empty collection or handle as needed
            return collect();
        }
    
        return $approvedZones;
    }

    public function RoomClient()
    {
        $currentDate = Carbon::now();

        $vipZones = Zone::with(['rooms', 'vipZonePositions.location'])
            ->join('users', 'zones.user_id', '=', 'users.id')
            ->join('vip_zone_positions', 'zones.id', '=', 'vip_zone_positions.zone_id')
            ->join('locations', 'vip_zone_positions.location_id', '=', 'locations.id')
            ->where('zones.status', self::HIEN_THI)
            ->where('locations.type_vip', self::DUOC_QUAN_TAM)  // Thay đổi type_vip thành DUOC_QUAN_TAM
            ->where('locations.status', self::VI_TRI_GOI_KICH_HOAT)
            ->where('vip_zone_positions.status', self::TRANG_THAI_VIP_HIEN_THI)
            ->where('vip_zone_positions.end_date', '>', $currentDate)
            ->select('zones.*', 'locations.name as location_name', 'vip_zone_positions.end_date')
            ->orderBy('vip_zone_positions.created_at', 'desc')
            ->take(5)
            ->get();

        if ($vipZones->isEmpty()) {
            // Nếu không có zone VIP, lấy các zone có view cao nhất
            return Zone::with('rooms')
                ->where('status', self::HIEN_THI)
                ->orderBy('view', 'desc')
                ->take(self::SO_LUONG_HIEN_THI)
                ->get();
        }

        return $vipZones;
    }
    // public function getRoomWhere()
    // {
    //     $currentDate = Carbon::now();

    //     $vipZones = Zone::with(['rooms', 'vipZonePositions.location'])
    //         ->join('users', 'zones.user_id', '=', 'users.id')
    //         ->join('vip_zone_positions', 'zones.id', '=', 'vip_zone_positions.zone_id')
    //         ->join('locations', 'vip_zone_positions.location_id', '=', 'locations.id')
    //         ->where('zones.status', self::HIEN_THI)
    //         ->where('locations.type_vip', self::NOI_O_LY_TUONG)
    //         ->where('locations.status', self::VI_TRI_GOI_KICH_HOAT)
    //         ->where('vip_zone_positions.status', self::TRANG_THAI_VIP_HIEN_THI)
    //         ->where('vip_zone_positions.end_date', '>', $currentDate)
    //         ->select('zones.*', 'locations.name as location_name', 'vip_zone_positions.end_date')
    //         ->orderBy('vip_zone_positions.created_at', 'desc')
    //         ->take(5)
    //         ->get();

    //     if ($vipZones->count() < self::SO_LUONG_HIEN_THI) {
    //         // Số lượng zone cần thêm
    //         $remainingCount = self::SO_LUONG_HIEN_THI - $vipZones->count();

    //         // Lấy các zone có view cao nhất, không bao gồm các zone đã có trong $vipZones
    //         $highViewZones = Zone::with('rooms')
    //             ->where('status', self::HIEN_THI)
    //             ->whereNotIn('id', $vipZones->pluck('id'))
    //             ->orderBy('view', 'desc')
    //             ->take($remainingCount)
    //             ->get();

    //         // Kết hợp các zone VIP và zone có view cao
    //         $combinedZones = $vipZones->concat($highViewZones);

    //         return $combinedZones;
    //     }

    //     return $vipZones;
    // }
    // Được quan tâm nhiều
    // public function RoomClient()
    // {
    //     return Zone::with('rooms') // Tải trước mối quan hệ rooms
    //         ->join('users', 'zones.user_id', '=', 'users.id')
    //         ->where('zones.status', self::HIEN_THI)
    //         ->select('zones.*')
    //         ->orderBy('zones.created_at', 'desc')
    //         ->take(5)
    //         ->get();
    // }
    // public function RoomClient()
    // {
    //     $currentDate = Carbon::now();

    //     return Zone::with(['rooms', 'vipZonePositions.location'])
    //         ->join('users', 'zones.user_id', '=', 'users.id')
    //         ->join('vip_zone_positions', 'zones.id', '=', 'vip_zone_positions.zone_id')
    //         ->join('locations', 'vip_zone_positions.location_id', '=', 'locations.id')
    //         ->where('zones.status', self::HIEN_THI)
    //         ->where('locations.type_vip', self::DUOC_QUAN_TAM)  // Thay đổi type_vip thành 2
    //         ->where('locations.status', self::VI_TRI_GOI_KICH_HOAT)
    //         ->where('vip_zone_positions.status', self::TRANG_THAI_VIP_HIEN_THI)
    //         ->where('vip_zone_positions.end_date', '>', $currentDate)
    //         ->select('zones.*', 'locations.name as location_name', 'vip_zone_positions.end_date')
    //         ->orderBy('vip_zone_positions.created_at', 'desc')
    //         ->take(5)
    //         ->get();
    // }
   
    // public function RoomClient()
    // {
    //     $currentDate = Carbon::now();

    //     $vipZones = Zone::with(['rooms', 'vipZonePositions.location'])
    //         ->join('users', 'zones.user_id', '=', 'users.id')
    //         ->join('vip_zone_positions', 'zones.id', '=', 'vip_zone_positions.zone_id')
    //         ->join('locations', 'vip_zone_positions.location_id', '=', 'locations.id')
    //         ->where('zones.status', self::HIEN_THI)
    //         ->where('locations.type_vip', self::DUOC_QUAN_TAM)
    //         ->where('locations.status', self::VI_TRI_GOI_KICH_HOAT)
    //         ->where('vip_zone_positions.status', self::TRANG_THAI_VIP_HIEN_THI)
    //         ->where('vip_zone_positions.end_date', '>', $currentDate)
    //         ->select('zones.*', 'locations.name as location_name', 'vip_zone_positions.end_date')
    //         ->orderBy('vip_zone_positions.created_at', 'desc')
    //         ->take(5)
    //         ->get();

    //     if ($vipZones->count() < self::SO_LUONG_HIEN_THI) {
    //         // Số lượng zone cần thêm
    //         $remainingCount = self::SO_LUONG_HIEN_THI - $vipZones->count();

    //         // Lấy các zone có view cao nhất, không bao gồm các zone đã có trong $vipZones
    //         $highViewZones = Zone::with('rooms')
    //             ->where('status', self::HIEN_THI)
    //             ->whereNotIn('id', $vipZones->pluck('id'))
    //             ->orderBy('view', 'desc')
    //             ->take($remainingCount)
    //             ->get();

    //         // Kết hợp các zone VIP và zone có view cao
    //         $combinedZones = $vipZones->concat($highViewZones);

    //         return $combinedZones;
    //     }

    //     return $vipZones;
    // }
    // public function getUniqueLocations()
    // {
    //     try {
    //         $provinces = Zone::distinct()->whereNotNull('province')->pluck('province', 'province')->toArray();
    //         $districts = Zone::distinct()->whereNotNull('district')->select('province', 'district')->get()
    //             ->groupBy('province')
    //             ->map(function ($items) {
    //                 return $items->pluck('district')->toArray();
    //             })
    //             ->toArray();
    //         $villages = Zone::distinct()->whereNotNull('village')->select('district', 'village')->get()
    //             ->groupBy('district')
    //             ->map(function ($items) {
    //                 return $items->pluck('village')->toArray();
    //             })
    //             ->toArray();

    //         return [
    //             'provinces' => $provinces,
    //             'districts' => $districts,
    //             'villages' => $villages
    //         ];
    //     } catch (\Exception $e) {
    //         Log::error('Không thể lấy danh sách địa điểm: ' . $e->getMessage());
    //         return null;
    //     }
    // }
    public function getUniqueLocations()
    {
        try {
            $provinces = Zone::distinct()->whereNotNull('province')->pluck('province', 'province')->toArray();
            $districts = Zone::distinct()->whereNotNull('district')->select('province', 'district')->get()
                ->groupBy('province')
                ->map(function ($items) {
                    return $items->pluck('district')->toArray();
                })
                ->toArray();
            $villages = Zone::distinct()->whereNotNull('village')->select('district', 'village')->get()
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
    public function getCategories()
    {
        return Category::whereHas('zones.rooms')
            ->select('id', 'name')
            ->get();
    }

    public function getAllRooms(int $perPage = 10, $type = null, $searchTerm = null, $province = null, $district = null, $village = null, $category = null, $features = null)
    {
        try {
            $query = Room::join('users', 'rooms.user_id', '=', 'users.id')
                ->join('zones', 'rooms.zone_id', '=', 'zones.id')
                ->where('rooms.status', self::status)
                ->select('rooms.*')
                ->orderByDesc('rooms.created_at');

            if ($type) {
                $query->whereHas('zone.category', function ($q) use ($type) {
                    $q->where('name', $type);
                });
            }

            if ($category) {
                $query->whereHas('zone', function ($q) use ($category) {
                    $q->where('category_id', $category);
                });
            }

            // ... (rest of the method remains the same)
        } catch (Exception $e) {
            Log::error('Error in getAllRooms: ' . $e->getMessage());
            return null;
        }
    }

    public function incrementViewCount($roomId)
    {
        if (!request()->cookie('viewed_room_' . $roomId)) {
            $room = Room::find($roomId);
            if ($room) {
                $room->increment('view');
                Cookie::queue('viewed_room_' . $roomId, true, 120);
            }
        }
    }

    public function getSlugRoom($slug)
    {
        try {
            return Room::where('slug', $slug)->first();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getRoomCount($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return Room::where('user_id', $userId)->count();
    }

    public function getRoomClient($province, $currentRoomId)
    {
        return Room::where('status', self::status)
            ->where('province', $province)
            ->where('id', '<>', $currentRoomId)
            ->get();
    }

    public function getAllRoomInCategory(int $perPage = 10, $type = null, $searchTerm = null, $province = null, $district = null, $village = null, $category = null)
    {
        try {
            $query = Room::join('users', 'rooms.user_id', '=', 'users.id')
                ->where('rooms.status', self::status)
                ->select('rooms.*')
                ->orderByDesc('rooms.created_at');

            if ($type) {
                $query->whereHas('category', function ($q) use ($type) {
                    $q->where('name', $type);
                });
            }

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('rooms.title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('rooms.description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('rooms.address', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($province) {
                $query->where('rooms.province', $province);
            }
            if ($district) {
                $query->where('rooms.district', $district);
            }
            if ($village) {
                $query->where('rooms.village', $village);
            }

            if ($category) {
                Log::info('Applying category filter: ' . $category);
                $query->where('rooms.category_id', $category);
            }

            $result = $query->get();
            Log::info('SQL Query: ' . $query->toSql());
            Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
            return $result;
        } catch (Exception $e) {
            Log::error('Error in getAllRoomInCategory: ' . $e->getMessage());
            return null;
        }
    }

    public function checkAndUpdateExpiredRooms()
    {
        $currentDate = Carbon::now();
        $expiredRooms = Room::where(function ($query) use ($currentDate) {
            $query->where('created_at', '<=', $currentDate->subDays(30))
                ->orWhereNull('created_at');
        })->get();

        $updatedCount = 0;

        if ($expiredRooms->isNotEmpty()) {
            foreach ($expiredRooms as $room) {
                $room->save();
                $updatedCount++;
            }
        }

        return $updatedCount;
    }

    public function getAllRoomAPI(int $perPage = 10, $type = null, $searchTerm = null, $province = null, $district = null, $village = null, $category = null, $features = null)
    {
        try {
            // $query = Zone::with('rooms') // Tải trước mối quan hệ rooms
            //     ->join('users', 'zones.user_id', '=', 'users.id')
            //     ->where('zones.status', self::status)
            //     ->select('zones.*')
            //     ->orderByDesc('zones.created_at');
            $query = Zone::with(['rooms' => function($query) {
                $query->select('id', 'zone_id', 'image', 'price'); // Lấy tất cả các trường cần thiết
            }])
            ->join('users', 'zones.user_id', '=', 'users.id')
            ->where('zones.status', self::status)
            ->select('zones.*')
            ->orderByDesc('zones.created_at');
            // $query = Zone::with(['rooms' => function($query) {
            //     $query->select('id', 'zone_id', 'image', 'price') // Chỉ lấy các trường cần thiết
            //           ->selectRaw('MAX(price) as max_price, MIN(price) as min_price') // Lấy giá trị max và min của cột price
            //           ->orderBy('id') // Sắp xếp để lấy hình đầu tiên
            //           ->take(1); // Lấy hình đầu tiên
            // }])
            // ->join('users', 'zones.user_id', '=', 'users.id')
            // ->where('zones.status', self::status)
            // ->select('zones.*')
            // ->orderByDesc('zones.created_at');
            if ($type) {
                $query->whereHas('category', function ($q) use ($type) {
                    $q->where('name', $type);
                });
            }

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('zones.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('zones.description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('zones.address', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($province) {
                $query->where('zones.province', $province);
            }
            if ($district) {
                $query->where('zones.district', $district);
            }
            if ($village) {
                $query->where('zones.village', $village);
            }
            if ($category) {
                Log::info('Applying category filter: ' . $category);
                $query->where('zones.category_id', $category);
            }

            if (!empty($features)) {
                $query->where(function ($q) use ($features) {
                    foreach ($features as $feature) {
                        $q->orWhere($feature, 2);
                    }
                });
            }

            $result = $query->get();
            Log::info('SQL Query: ' . $query->toSql());
            Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
            return $result;
        } catch (Exception $e) {
            Log::error('Error in getAllRoomAPI: ' . $e->getMessage());
            return null;
        }
    }
    public function getPopularRooms($limit = 3)
    {
        $currentDate = Carbon::now();

        return Room::where('status', self::status)
            ->where(function ($query) use ($currentDate) {
                $query->where('vip_expiry_date', '>', $currentDate)
                    ->orWhereNull('vip_expiry_date');
            })
            ->orderByRaw('CASE 
                WHEN vip_expiry_date > ? THEN 0 
                ELSE 1 
            END', [$currentDate])
            ->orderByRaw('CASE 
                WHEN vip_expiry_date > ? THEN view 
                ELSE 0 
            END DESC', [$currentDate])
            ->orderBy('view', 'desc')
            ->take($limit)
            ->get();
    }

}
