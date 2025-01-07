<?php

namespace App\Services;

use App\Models\Zone;
use App\Models\Resident;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use App\Events\Admin\ZoneUpdated;
use App\Models\PriceList;
use App\Models\Transaction;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Events\BillCreated;
use GuzzleHttp\Client;
use App\Models\Category;
use App\Models\Notification;
use App\Models\VipZonePosition;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Services\BlogServices;
use App\Http\Requests\ZoneRequest;

class ZoneServices
{
    const CO = 1; // Có tiện ích
    const CHUA_CO = 0; // Chưa có tiện ích
    const DA_TAO = 1; // Trạng thái tạo hóa đơn
    protected $client;
    protected $blogServices;
    private const status = 2;
    private const phong_noi_bat = 3;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.clarifai.com/v2/',
            'headers' => [
                'Authorization' => 'Key ' . env('CLARIFAI_API_KEY'),
                'Content-Type' => 'application/json',
            ]
        ]);
        $this->blogServices = new BlogServices();
    }
    public function getRoomUtilities($zoneId)
    {
        // Giả sử bạn đã có model `Utility`
        // return Utility::where('zone_id', $zoneId)->first();
    }
    public function getZoneClient($province, $currentZoneId)
    {
        return Zone::where('status', self::status)
            ->where('province', $province)
            ->where('id', '<>', $currentZoneId)
            ->get();
    }

    public function store($request)
    {
        if (auth()->check()) {
            $zone = new Zone();
            $user_id = auth()->id();
            $zone->name = $request->input('name');
            $zone->description = $request->input('description');
            $zone->address = $request->input('address');
            $zone->province = $request->input('province');
            $zone->district = $request->input('district');
            $zone->village = $request->input('village');
            $zone->latitude = $request->input('latitude');
            $zone->longitude = $request->input('longitude');
            $zone->status = $request->input('status');
            $zone->user_id = $user_id;
            $zone->phone = $request->input('phone');
            $zone->category_id = $request->input('category_id');
            $zone->wifi = $request->input('wifi');
            $zone->air_conditioning = $request->input('air_conditioning');
            $zone->garage = $request->input('garage');
            $zone->bathrooms = $request->input('bathrooms');

            if ($zone->save()) {
                $zoneId = $zone->id;
                $slug = $this->createSlug($request->input('name')) . '-' . $zoneId;
                $zone->slug = $slug;

                if ($zone->save()) {
                    if ($request->hasFile('images')) {
                        $violentImages = [];

                        foreach ($request->file('images') as $image) {
                            if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                                if ($image->getSize() <= 5242880) { // 5MB
                                    $imageContent = base64_encode(file_get_contents($image->getRealPath()));
                                    try {
                                        $response = $this->client->post('models/moderation-recognition/outputs', [
                                            'json' => [
                                                'inputs' => [
                                                    [
                                                        'data' => [
                                                            'image' => [
                                                                'base64' => $imageContent
                                                            ]
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]);

                                        $result = json_decode($response->getBody(), true);
                                        $concepts = $result['outputs'][0]['data']['concepts'] ?? [];
                                        $violenceScore = 0;

                                        $inappropriateContent = ['gore', 'explicit', 'drug', 'suggestive', 'weapon'];

                                        foreach ($concepts as $concept) {
                                            if (in_array($concept['name'], $inappropriateContent)) {
                                                $violenceScore += $concept['value'];
                                                Log::info("Inappropriate content detected: " . $concept['name'] . " with score: " . $concept['value']);
                                            }
                                        }

                                        // Log tổng điểm nội dung không phù hợp
                                        Log::info("Total inappropriate content score for image: " . $image . " is " . $violenceScore);
                                        if ($violenceScore > 0.5) {
                                            $violentImages[] = $image->getClientOriginalName();
                                        } else {
                                            $this->storeImage($zone, $image);
                                        }
                                    } catch (\Exception $e) {
                                        \Log::error("Error processing image: " . $e->getMessage());
                                        return ['success' => false, 'message' => 'Có lỗi xảy ra khi xử lý ảnh: ' . $e->getMessage()];
                                    }
                                }
                            }
                        }

                        if (!empty($violentImages)) {
                            $zone->delete(); // Xóa zone nếu có ảnh không phù hợp
                            return ['success' => false, 'message' => 'Phát hiện ảnh không phù hợp: ' . implode(', ', $violentImages) . '. Vui lòng kiểm tra lại ảnh của bạn.'];
                        }
                    }

                    // $utilities = new Utility();
                    // $utilities->zone_id = $zoneId;
                    // $utilities->wifi = $request->has('wifi') ? self::CO : self::CHUA_CO;
                    // $utilities->air_conditioning = $request->has('air_conditioning') ? self::CO : self::CHUA_CO;
                    // $utilities->garage = $request->has('garage') ? self::CO : self::CHUA_CO;
                    // $utilities->bathrooms = $request->input('bathrooms', 0);
                    // $utilities->save();

                    return ['success' => true, 'zone' => $zone];
                } else {
                    $zone->delete();
                    return ['success' => false, 'message' => 'Không thể lưu slug cho khu trọ.'];
                }
            } else {
                return ['success' => false, 'message' => 'Không thể lưu thông tin khu trọ.'];
            }
        } else {
            return ['success' => false, 'message' => 'Người dùng chưa đăng nhập.'];
        }
    }

    /**
     * Tạo slug từ một chuỗi văn bản
     * 
     * @param string $string
     * @return string
     */
    protected function createSlug($string)
    {
        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim($string));
        $slug = strtolower($slug);
        $slug = trim($slug, '-');
        return $slug;
    }
    public function getCategories()
    {
        return Category::whereHas('zones') // Ensure the category has related rooms
            ->select('id', 'name')
            ->get();
    }
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
    public function getPopularZones($limit = 3)
    {
        $currentDate = Carbon::now();

        return Zone::where('status', self::status)
            ->orderBy('view', 'desc')
            ->take($limit)
            ->get();
    }
    public function countRoomsInZone($zone_id)
    {
        // Đếm số phòng trong zone_id cụ thể
        return Room::where('zone_id', $zone_id)->count();
    }

    public function getMyZone($user_id)
    {
        $perPage = 10;
        $zones = Zone::where('user_id', $user_id)->orderByDesc('created_at')->paginate($perPage);
        return $zones;
    }
    // Danh sách khu vực trọ Client
    // public function getMyZoneClient()
    // {
    //     $perPage = 5;
    //     $zones = Zone::orderByDesc('created_at')->paginate($perPage); // sắp xếp
    //     return $zones;
    // }
    public function getMyZoneClient()
    {
        $perPage = 5; // Số lượng khu vực trọ sẽ được hiển thị trên mỗi trang
        $zones = Zone::where('status', self::status) // Chỉ lấy các khu vực có status = 2
            ->orderByDesc('created_at') // Sắp xếp theo ngày tạo mới nhất
            ->paginate($perPage); // Phân trang kết quả
        return $zones; //
    }
    // Tổng só khu trọ Client
    public function getTotalZones()
    {
        return Zone::count(); // Đếm tổng số khu vực trọ
    }

    public function getTotalZonesByUser($userId = null)
    {
        try {
            // Use the provided userId or fall back to the currently authenticated user
            $userId = $userId ?? Auth::id();

            // Count the number of zones for the specified user
            return Zone::where('user_id', $userId)->count();
        } catch (\Exception $e) {
            // Log the error and return 0 in case of any issues
            Log::error('Error counting zones: ' . $e->getMessage());
            return 0;
        }
    }
    // Xem chi tiết khu trọ CLient theo Slug
    public function getZoneDetailsBySlug($slug)
    {
        // Tìm khu vực trọ dựa trên slug
        return Zone::where('slug', $slug)->firstOrFail();
    }
    /**
     * Lưu ảnh
     * 
     * @param Zone $zone
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    // protected function storeImage(Zone $zone, $image)
    // {
    //     $timestamp = now()->format('YmdHis');
    //     $originalName = $image->getClientOriginalName();
    //     $extension = $image->getClientOriginalExtension();
    //     $filename = $timestamp . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;

    //     $path = 'assets/images/' . $filename;
    //     $image->move(public_path('assets/images'), $filename);

    //     // Giả sử bạn có mối quan hệ giữa Zone và Room, và bạn muốn lưu hình ảnh vào cột 'image' của Room
    //     $room = $zone->rooms()->first(); // Lấy room đầu tiên liên quan đến zone này, hoặc bạn có thể xác định room cụ thể
    //     if ($room) {
    //         $room->image = $filename; // Lưu tên file vào cột 'image' của room
    //         $room->save();
    //     }
    // }
    public function getZoneVipPosition()
    {
        $location = Location::where('type_vip', self::phong_noi_bat)->get();
        $data = VipZonePosition::whereIn('location_id', $location->pluck('id'))->get();
        return $data;
    }

    public function getZoneVip()
    {
        // Retrieve zones that are associated with a location_id in the vip_zone_position table
        // where the type_vip in the location table is 3
        $zones = Zone::whereIn('id', function ($query) {
            $query->select('zone_id')
                ->from('vip_zone_position')
                ->whereIn('location_id', function ($subQuery) {
                    $subQuery->select('id')
                        ->from('location')
                        ->where('type_vip', 3);
                });
        })->get();
        dd($zones);
        return $zones;
    }
    public function getAllZones(int $perPage = 10, $searchTerm = null)
    {
        try {
            $query = Zone::query();

            if ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            }

            // Sắp xếp theo ngày tạo mới nhất
            $query->orderBy('created_at', 'desc');

            return $query->paginate($perPage);
        } catch (\Exception $e) {
            return null;
        }
    }
    // Chi tiết khu trọ
    public function showDetail($slug, $status)
    {
        // Tìm zone dựa trên slug
        $zone = Zone::where('slug', $slug)->firstOrFail();

        // Lấy danh sách phòng thuộc zone này
        $rooms = Room::where('zone_id', $zone->id)->paginate(10);

        // Lấy danh sách người ở (residents) thuộc zone này
        $residents = Resident::whereIn('room_id', $rooms->pluck('id'))
            // ->where('zone_id', $zone->id)
            ->where('status', $status) // Chỉ lấy resident có status = 2
            ->with('user') // Nạp thông tin người dùng liên quan
            ->paginate(10);

        return [
            'zone' => $zone,
            'rooms' => $rooms,
            'residents' => $residents,
        ];
    }
    // Xóa mềm Residents
    public function softDeleteResident($residentId)
    {
        $resident = Resident::findOrFail($residentId);
        $resident->delete();
        return $resident;
    }
    // Tạo Hóa Đơn Khu Trọ Bills
    public function createBill($data)
    {
        $data['status'] = self::DA_TAO;
        $data['payment_date'] = now();

        // Kiểm tra và thêm hạn thanh toán nếu có
        if (isset($data['payment_due_date'])) {
            $data['payment_due_date'] = $data['payment_due_date']; // Giữ nguyên giá trị từ form
        } else {
            $data['payment_due_date'] = now(); // Nếu không có, mặc định là hiện tại
        }

        $bill = Bill::create($data);
        event(new BillCreated($bill, $data['payer_id']));
        return $bill;
    }


    public function findById($id)
    {
        return Zone::find($id);
    }

    // Phương thức để cập nhật khu trọ
    // public function update($request, $id)
    // {
    //     // Tìm khu trọ theo ID
    //     $zone = Zone::find($id);

    //     // Nếu khu trọ tồn tại, thực hiện cập nhật và kích hoạt sự kiện
    //     if ($zone) {
    //         $zone->update($request->all());

    //         // Kích hoạt sự kiện
    //         event(new ZoneUpdated($zone));

    //         return true;
    //     }

    //     // Trả về false nếu không tìm thấy khu trọ
    //     return false;
    // }
    public function getIdZone($slug)
    {
        $zone = Zone::where('slug', $slug)->first();
        return $zone;
    }
    public function countTotalZones()
    {
        try {
            // Đếm tổng số bản ghi trong bảng zones
            return Zone::count(); // Chỉnh sửa tên lớp từ `zones` thành `Zone` (nếu `Zone` là tên mô hình của bạn)
        } catch (\Exception $e) {
            // Ghi log lỗi nếu có ngoại lệ
            Log::error('Error counting zones: ' . $e->getMessage());
            // Trả về 0 nếu có lỗi
            return 0;
        }
    }



    public function updateZone(ZoneRequest $request, $zoneId)
    {
        // Tìm khu trọ theo ID
        $zone = Zone::find($zoneId);

        // Kiểm tra xem khu trọ có tồn tại không
        if (!$zone) {
            return ['success' => false, 'message' => 'Không tìm thấy khu trọ.'];
        }

        // Cập nhật các trường, giữ nguyên nếu không nhập giá trị mới
        $zone->name = $request->input('title') ?? $zone->name;
        $zone->description = $request->input('description') ?? $zone->description;
        $zone->address = $request->input('address') ?? $zone->address;
        $zone->province = $request->input('province') ?? $zone->province;
        $zone->district = $request->input('district') ?? $zone->district;
        $zone->village = $request->input('village') ?? $zone->village;
        $zone->latitude = $request->input('latitude') ?? $zone->latitude;
        $zone->longitude = $request->input('longitude') ?? $zone->longitude;
        $zone->status = $request->input('status') ?? $zone->status;
        $zone->category_id = $request->input('category_id') ?? $zone->category_id;
        $zone->phone = $request->input('phone') ?? $zone->phone;
        // Cập nhật các trường boolean
        $zone->wifi = $request->has('wifi') ? self::CO : $zone->wifi;
        $zone->bathrooms = $request->has('bathrooms') ? self::CO : $zone->bathrooms;
        $zone->air_conditioning = $request->has('air_conditioning') ? self::CO : $zone->air_conditioning;
        $zone->garage = $request->has('garage') ? self::CO : $zone->garage;

        // Lưu thông tin khu trọ
        if ($zone->save()) {
            // Tạo slug mới
            $zone->slug = $this->createSlug($zone->name) . '-' . $zone->id;

            // Cập nhật slug trong cơ sở dữ liệu
            if ($zone->save()) {
                return ['success' => true, 'zone' => $zone];
            } else {
                \Log::error('Không thể lưu slug cho khu trọ.');
                return ['success' => false, 'message' => 'Không thể lưu slug cho khu trọ.'];
            }
        } else {
            // Ghi lại lỗi nếu không thể lưu thông tin
            \Log::error('Không thể lưu thông tin khu trọ:', ['errors' => $zone->getErrors()]);
            return ['success' => false, 'message' => 'Không thể lưu thông tin cập nhật khu trọ.'];
        }
    }







    public function softDeleteZones($id)
    {
        // Tìm zone theo ID
        $zone = Zone::findOrFail($id);

        // Kiểm tra xem có phòng nào thuộc zone này chưa bị xóa mềm hay không
        $activeRooms = Room::where('zone_id', $id)->whereNull('deleted_at')->exists();

        if ($activeRooms) {
            // Nếu có phòng đang hoạt động, trả về thông báo lỗi
            return [
                'status' => 'error',
                'message' => 'Khu trọ đang có phòng hoạt động, không thể xóa.'
            ];
        }

        // Kiểm tra xem có user_id nào đang ở trong resident thuộc zone này không
        // $activeResidents = Resident::where('zone_id', $id)
        //     ->whereNotNull('user_id')
        //     ->exists();

        // if ($activeResidents) {
        //     // Nếu có user_id đang ở trong resident, trả về thông báo lỗi
        //     return [
        //         'status' => 'error',
        //         'message' => 'Khu trọ đang có người ở, không thể xóa.'
        //     ];
        // }

        // Nếu tất cả các phòng đều đã bị xóa mềm và không có người ở, tiến hành xóa mềm zone
        $zone->delete();

        // Trả về thông báo thành công
        return [
            'status' => 'success',
            'message' => 'Khu trọ đã được xóa thành công.'
        ];
    }



    public function getTrashedZones()
    {
        $userId = Auth::id(); // Lấy ID của người dùng đang đăng nhập

        return Zone::onlyTrashed()
            ->where('user_id', $userId) // Lọc theo user_id
            ->orderBy('created_at', 'desc') // Sắp xếp từ mới nhất đến cũ nhất
            ->get();
    }

    public function getProvinces()
    {
        return Zone::select('province')->distinct()->get();
    }
    public function restoreMultipleZones($ids)
    {
        return Zone::withTrashed()->whereIn('id', $ids)->restore();
    }

    public function restoreZones($id)
    {
        $zone = Zone::withTrashed()->findOrFail($id);
        $zone->restore();
        return $zone;
    }
    public function forceDeleteZones($id)
    {
        // Tìm zone theo ID kể cả khi đã bị xóa mềm
        $zone = Zone::withTrashed()->findOrFail($id);

        // Kiểm tra xem có phòng nào thuộc zone này chưa bị xóa mềm hay không
        $activeRooms = Room::where('zone_id', $id)->whereNull('deleted_at')->exists();

        if ($activeRooms) {
            // Nếu có phòng đang hoạt động, trả về thông báo lỗi
            return [
                'status' => 'error',
                'message' => 'Khu trọ đang có phòng hoạt động, không thể xóa vĩnh viễn.'
            ];
        }

        // Kiểm tra xem có user_id nào đang ở trong resident thuộc zone này không
        $activeResidents = Resident::where('zone_id', $id)
            ->whereNotNull('user_id')
            ->exists();

        if ($activeResidents) {
            // Nếu có user_id đang ở trong resident, trả về thông báo lỗi
            return [
                'status' => 'error',
                'message' => 'Khu trọ đang có người ở, không thể xóa vĩnh viễn.'
            ];
        }

        // Nếu tất cả các phòng đều đã bị xóa mềm và không có người ở, tiến hành xóa vĩnh viễn zone
        $zone->forceDelete();

        // Trả về thông báo thành công
        return [
            'status' => 'success',
            'message' => 'Khu trọ đã được xóa vĩnh viễn thành công.'
        ];
    }
    public function searchZones($keyword, $province, $category)
    {
        $query = Zone::where('status', self::status);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%');
            });
        }

        if ($province) {
            $query->where('province', $province);
        }
        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category);
            });
        }

        return $query->paginate(10); // Trả về đối tượng Paginator
    }
    public function searchZonesWithinRadius($latitude = null, $longitude = null, $radius = 30, $perPage = 10)
    {
        $query = Zone::where('status', self::status);


        if ($latitude && $longitude) {
            $haversine = "(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude))))";
            $query->select('*')
                ->selectRaw("{$haversine} AS distance")
                ->having('distance', '<', $radius)
                ->orderBy('distance');
        } else {
            $query->orderByDesc('created_at');
        }

        return $query->paginate($perPage);
    }
    public function deleteZone($id)
    {
        // Tìm zone theo id hoặc trả về lỗi nếu không tìm thấy
        $zone = Zone::findOrFail($id);

        // Xóa zone
        $zone->delete();
    }
    public function incrementViewCount($zoneId)
    {
        if (!request()->cookie('viewed_zone_' . $zoneId)) {
            $zone = Zone::find($zoneId);
            if ($zone) {
                $zone->increment('view');
                Cookie::queue('viewed_zone_' . $zoneId, true, 120);
            }
        }
    }
    public function create($request)
    {
        if (!auth()->check()) {
            return false;
        }

        DB::beginTransaction(); // Bắt đầu giao dịch

        try {
            $zone = new Zone();
            $user_id = auth()->id();
            $user = auth()->user();
            $zone->status = ($user->has_vip_badge && $user->vip_expiration_date > now()) ? 2 : 1;
            $zone->name = $request->input('title');
            $zone->description = $request->input('description');
            $zone->phone = $request->input('phone');
            $zone->address = $request->input('address');
            $zone->view = $request->input('view');
            $zone->province = $request->input('province');
            $zone->district = $request->input('district');
            $zone->village = $request->input('village');
            $zone->longitude = $request->input('longitude');
            $zone->latitude = $request->input('latitude');
            $zone->user_id = $user_id;
            $zone->category_id = $request->input('category_id');
            $zone->wifi = $request->has('wifi') ? self::CO : self::CHUA_CO;
            $zone->bathrooms = $request->has('bathrooms') ? self::CO : self::CHUA_CO;
            $zone->air_conditioning = $request->has('air_conditioning') ? self::CO : self::CHUA_CO;
            $zone->garage = $request->has('garage') ? self::CO : self::CHUA_CO;

            if (!$zone->save()) {
                DB::rollBack();
                return false;
            }

            $zoneId = $zone->id;
            $slug = $this->createSlug($request->input('title')) . '-' . $zoneId;
            $zone->slug = $slug;

            if (!$zone->save()) {
                DB::rollBack();
                return false;
            }

            // Kiểm tra nếu người dùng chưa tải lên ảnh
            if (!$request->hasFile('image')) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng tải lên ít nhất một hình ảnh.'
                ]);
            }

            // Tiếp tục xử lý ảnh nếu có
            $image = $request->file('image');
            $isValidImage = false;
            Log::info("Starting image processing...");

            try {
                $timestamp = now()->format('YmdHis');
                $originalName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $filename = $timestamp . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;

                Log::info("Checking image with Clarifai: " . $filename);

                $imageContent = base64_encode(file_get_contents($image->getRealPath()));

                $response = $this->client->post('models/moderation-recognition/outputs', [
                    'json' => [
                        'inputs' => [
                            [
                                'data' => [
                                    'image' => [
                                        'base64' => $imageContent
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);

                $result = json_decode($response->getBody(), true);
                Log::info("Clarifai response: " . json_encode($result));

                $concepts = $result['outputs'][0]['data']['concepts'] ?? [];
                $violenceScore = 0;

                $inappropriateContent = ['gore', 'explicit', 'drug', 'suggestive', 'weapon'];

                foreach ($concepts as $concept) {
                    if (in_array($concept['name'], $inappropriateContent)) {
                        $violenceScore += $concept['value'];
                        Log::info("Inappropriate content detected: " . $concept['name'] . " with score: " . $concept['value']);
                    }
                }

                Log::info("Total inappropriate content score for image: " . $filename . " is " . $violenceScore);

                if ($violenceScore <= 0.5) {
                    $isValidImage = true;
                } else {
                    Log::warning("Image rejected due to high inappropriate content score: " . $filename);
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Phát hiện ảnh không phù hợp: ' . $filename . '. Vui lòng kiểm tra lại ảnh của bạn.'
                    ]);
                }
            } catch (GuzzleException $e) {
                Log::error("Clarifai API error: " . $e->getMessage());
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Có lỗi xảy ra khi kiểm tra ảnh: ' . $e->getMessage()
                ]);
            } catch (\Exception $e) {
                Log::error("Error processing image: " . $e->getMessage());
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Có lỗi xảy ra khi xử lý ảnh: ' . $e->getMessage()
                ]);
            }

            if (!$isValidImage) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không có ảnh nào được tải lên. Vui lòng thử lại.'
                ]);
            }

            DB::commit(); // Commit transaction
            return $zoneId;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction
            Log::error('Error creating zone: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi tạo khu vực: ' . $e->getMessage()
            ]);
        }
    }

    public function getSlug($id)
    {
        $zone = Zone::find($id);
        return $zone->slug;
    }
    public function getRoomsWithStatus(int $status, int $perPage = 10)
    {
        try {
            return Zone::where('status', $status)->paginate($perPage);
        } catch (\Exception $e) {
            Log::error('Không thể lấy danh sách phòng với status ' . $status . ': ' . $e->getMessage());
            return null;
        }
    }

    public function getOwnerId($zone_id)
    {
        // Truy vấn tới bảng zones để lấy user_id của zone
        $zone = Zone::find($zone_id);

        if ($zone) {
            return $zone->user_id; // Trả về user_id của người tạo zone
        }

        return null; // Trả về null nếu không tìm thấy zone
    }

    //Hàm mua vip khu trọ 
    public function processZonePayment($customer, $accommodation, $pricingId)
    {
        try {
            // Lấy thông tin của gói VIP từ PriceList
            $pricing = PriceList::findOrFail($pricingId);
            $cost = $pricing->price;
            $validity = $pricing->duration_day; // Đây có thể là string

            // Trừ tiền từ số dư tài khoản của người dùng
            $customer->balance -= $cost;
            $customer->save();

            $newExpiry = Carbon::now()->addDays((int) $validity);

            // Kiểm tra xem có VipZonePosition với cùng zone_id và location_id không
            $vipZonePosition = VipZonePosition::where('zone_id', $accommodation->id)
                ->where('location_id', $pricing->location_id)
                ->first();

            if ($vipZonePosition) {
                // Nếu đã tồn tại, cập nhật end_date
                if (Carbon::parse($vipZonePosition->end_date)->isFuture()) {
                    $vipZonePosition->end_date = Carbon::parse($vipZonePosition->end_date)->addDays((int) $validity);
                } else {
                    $vipZonePosition->end_date = $newExpiry;
                }
            } else {
                // Nếu không tồn tại, tạo mới
                $vipZonePosition = new VipZonePosition();
                $vipZonePosition->zone_id = $accommodation->id;
                $vipZonePosition->location_id = $pricing->location_id;
                $vipZonePosition->end_date = $newExpiry;
            }

            $vipZonePosition->save();

            // Lưu lịch sử thanh toán
            $lichsu = new Transaction();
            $lichsu->type = $pricing->location->name;
            $lichsu->balance = $customer->balance;
            $lichsu->description = 'Thanh toán gói tin VIP cho khu trọ ' . $accommodation->name;
            $lichsu->added_funds = $cost;
            $lichsu->status = 2;
            $lichsu->user_id = $customer->id;
            $lichsu->save();

            $thonngbao = new Notification();
            $thonngbao->user_id = $customer->id;
            $thonngbao->type = 'Thanh toán';
            $thonngbao->data = 'Thanh toán gói tin VIP cho khu trọ ' . $accommodation->name . ' thành công';
            $thonngbao->save();

            return true;
        } catch (\Exception $e) {
            // Nếu có lỗi trong quá trình thanh toán, ghi log lỗi
            \Log::error('Lỗi khi thực hiện thanh toán: ' . $e->getMessage());
            return false;
        }
    }

    public function checkAndUpdateExpiredZones()
    {
        // Lấy ngày hiện tại
        $currentDate = Carbon::now();

        // Tìm các zone có vip_expiry_date nhỏ hơn ngày hiện tại
        VipZonePosition::where('end_date', '<', $currentDate)->forceDelete();
        $expiredZones = VipZonePosition::where('end_date', '<', $currentDate)->get();
        $updatedCount = 0;

        if ($expiredZones->isNotEmpty()) {
            foreach ($expiredZones as $zone) {
                // Tạo thông báo cho người dùng
                $notification = new Notification();
                $notification->user_id = $zone->user_id;
                $notification->type = 'Gói Tin VIP';
                $notification->data = 'Gói tin VIP của bạn cho khu trọ ' . $zone->name . ' đã hết hạn.';
                $notification->save();
            }
        }
        return $updatedCount; // Trả về số lượng zone đã được cập nhật
    }
    public function createMultiple($data)
    {
        $zone = new Zone();
        $zone->status = 1; // Mặc định trạng thái
        $zone->name = $data['title'] ?? ''; // Kiểm tra nếu có
        $zone->description = $data['description'] ?? '';
        $zone->phone = $data['phone'] ?? '1';
        $zone->address = $data['address'] ?? '';
        $zone->view = 0; // Giá trị mặc định
        $zone->province = ''; // Cung cấp giá trị nếu cần
        $zone->district = ''; // Cung cấp giá trị nếu cần
        $zone->village = ''; // Cung cấp giá trị nếu cần
        $zone->longitude = $data['longitude'] ?? 0; // Giá trị mặc định
        $zone->latitude = $data['latitude'] ?? 0; // Giá trị mặc định
        $zone->user_id = 17; // Lấy ID người dùng đang đăng nhập
        $zone->category_id = 4; // Giá trị mặc định
        $zone->status = 2;
        $zone->wifi = isset($data['wifi']) && $data['wifi'] ? self::CO : self::CHUA_CO;
        $zone->bathrooms = isset($data['bathrooms']) && $data['bathrooms'] ? self::CO : self::CHUA_CO;
        $zone->air_conditioning = isset($data['air_conditioning']) && $data['air_conditioning'] ? self::CO : self::CHUA_CO;
        $zone->garage = isset($data['garage']) && $data['garage'] ? self::CO : self::CHUA_CO;
        $zoneId = $zone->id;
        $slug = $this->createSlug($data['title']) . '-' . $zoneId;
        $zone->slug = $slug;
        $zone->save(); // Lưu từng zone

        // Tạo một đối tượng Room mới
        $room = new Room();
        $room->title =  'Phòng 1'; // Lấy tên phòng từ dữ liệu
        $room->description = $data['description'] ?? ''; // Lấy mô tả phòng từ dữ liệu
        $room->price = $data['price'] ?? 0; // Lấy giá phòng từ dữ liệu
        $room->quantity = 1; // Lấy số lượng phòng từ dữ liệu, mặc định là 1
        $room->zone_id = $zone->id; // Gán zone_id cho phòng

        // Kiểm tra và lưu hình ảnh
        if (isset($data['image'])) {
            $imageUrl = $data['image']; // Đường dẫn hình ảnh
            $imageContent = @file_get_contents($imageUrl);

            if ($imageContent !== false) {
                // Tạo một đối tượng UploadedFile giả để sử dụng hàm uploadImageToGoogleDrive
                $tempFilePath = tempnam(sys_get_temp_dir(), 'image');
                file_put_contents($tempFilePath, $imageContent);
                $uploadedFile = new \Illuminate\Http\UploadedFile(
                    $tempFilePath,
                    basename($imageUrl),
                    mime_content_type($tempFilePath),
                    null,
                    true
                );

                $folderId = env('GOOGLE_DRIVE_FOLDER_ID'); // Lấy ID thư mục từ .env
                $filename = time() . '_' . basename($imageUrl); // Tạo tên file mới

                // Gọi hàm uploadImageToGoogleDrive
                $uploadResult = $this->blogServices->uploadImageToGoogleDrive($uploadedFile, $folderId, $filename);

                if (isset($uploadResult['id'])) {
                    // Lưu ID của file trên Google Drive vào cơ sở dữ liệu
                    $room->image = $uploadResult['id'];
                } else {
                    // Xử lý lỗi nếu không thể tải lên
                    Log::error('Không thể tải lên hình ảnh: ' . json_encode($uploadResult));
                    return false;
                }
            } else {
                echo "Không thể tải hình ảnh từ URL: $imageUrl<br>";
            }
        }

        $room->save();

        return true; // Trả về true nếu thành công
    }
}
