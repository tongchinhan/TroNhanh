<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RoomClientServices;
use App\Services\PremiumService;
use App\Services\AccountService;
use App\Events\ExpiredEntitiesUpdateEvent;
use App\Services\UserClientServices;
use App\Services\ZoneServices;
use App\Services\ZoneClientService;

class HomeClientController extends Controller
{
    protected $roomClientService;
    protected $premiumService;
    protected $accountService;
    protected $zoneServices;
    protected $zoneClientService;
    protected $userClientServices;
    public function __construct(UserClientServices $userClientServices, RoomClientServices $roomClientService, PremiumService $premiumService, AccountService $accountService, ZoneServices $zoneServices)
    {
        $this->zoneServices = $zoneServices;
        $this->roomClientService = $roomClientService;
        $this->userClientServices = $userClientServices;
        $this->premiumService = $premiumService;
        $this->accountService = $accountService;
    }
    // public function index(Request $request)
    // {
    //     $user = Auth::user();
    //     $rooms = $this->roomClientService->getRoomWhere();
    //     $roomClient = $this->roomClientService->RoomClient();
    //     // $locations = $this->roomClientService->getUniqueLocations();
    //     $categories = $this->roomClientService->getCategories();
    //     if ($request->ajax() || $request->wantsJson()) {
    //         return response()->json([
    //             'roomClient' => $roomClient,
    //             'categories' => $categories,
    //             'rooms' => $rooms,
    //             // 'provinces' => $locations['provinces'],
    //             // 'districts' => $locations['districts'],
    //             // 'villages' => $locations['villages'],
    //             'province' => request()->input('province', '')
    //         ]);
    //     }
    //     event(new ExpiredEntitiesUpdateEvent());
    //     // event(new ServiceMailsSummaryEvent());
    //     return view('client.show.home', [
    //         'roomClient' => $roomClient,
    //         'categories' => $categories,
    //         'rooms' => $rooms,
    //         // 'provinces' => $locations['provinces'],
    //         // 'districts' => $locations['districts'],
    //         // 'villages' => $locations['villages'],
    //         'province' => request()->input('province', '') // Truyền biến province từ request hoặc giá trị mặc định
    //     ]);
    // }
    public function index(Request $request)
    {
        $user = Auth::user();
        $zones = $this->roomClientService->getRoomWhere();
        $zoneClient = $this->roomClientService->RoomClient();
        $approvedRoomsInHCM = $this->roomClientService->getApprovedZonesInHCM();
        $approvedRoomsInHanoi = $this->roomClientService->getApprovedZonesInHanoi();
        $approvedRoomsInCanTho = $this->roomClientService->getApprovedZonesInCanTho();
        $locations = $this->roomClientService->getUniqueLocations();
        $categories = $this->roomClientService->getCategories();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'zoneClient' => $zoneClient,
                'categories' => $categories,
                'zones' => $zones,
                'approvedRoomsInHCM' => $approvedRoomsInHCM,
                'approvedRoomsInHanoi' => $approvedRoomsInHanoi,
                'approvedRoomsInCanTho' => $approvedRoomsInCanTho,
                'provinces' => $locations['provinces'],
                'districts' => $locations['districts'],
                'villages' => $locations['villages'],
                'province' => request()->input('province', '')
            ]);
        }

        event(new ExpiredEntitiesUpdateEvent());

        return view('client.show.home', [
            'zoneClient' => $zoneClient,
            'categories' => $categories,
            'zones' => $zones,
            'approvedRoomsInHCM' => $approvedRoomsInHCM,
            'approvedRoomsInHanoi' => $approvedRoomsInHanoi,
            'approvedRoomsInCanTho' => $approvedRoomsInCanTho,
            'provinces' => $locations['provinces'],
            'districts' => $locations['districts'],
            'villages' => $locations['villages'],
            'province' => request()->input('province', '')
        ]);
    }
    // public function showAboutt(Request $request){
    //         $keyword = $request->input('keyword');
    //         $province = $request->input('province');
    //         $latitude = $request->input('latue');  
    //         $longtitude = $request->input('longtitude');
    //         if($latitude && $longtitude){
    //             $zones = $this->zoneServices->searchZonesWithinRadius($latitude, $longtitude, 30); 
    //         }elseif($keyword ||  $province ){
    //            $zones = $this->zoneServices->searchZones($keyword , $province, null);

    //         }else{
    //             $userLat = session('userLat');
    //             $userLng = session('userLng');
    //             if ($userLat && $userLng){
    //                 $zones = $this->zoneServices->searchZonesWithinRadius($userLat, $userLng,30);

    //             }else{
    //                 $zones = $this->zoneServices->getMyZoneClient();
    //             }
    //         }
    //         $province = $this->zoneServices->getProvinces()->pluck('province')->toArray();
    //         if ($request ->ajax()){
    //             return response()->json([   
    //                    'zones' => $zones->items(),
    //                     'totalZones' => $totalZones,
    //                     'pagination' => (string ) $zones->link()
    //             ]);
    //         }
    // }
    // Giao diện Về Chúng Tôi
    public function showAbout(Request $request)
    {
        $keyword = $request->input('keyword');
        $province = $request->input('province');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        if ($latitude && $longitude) {
            $zones = $this->zoneServices->searchZonesWithinRadius($latitude, $longitude, 30);
        } elseif ($keyword || $province) {
            $zones = $this->zoneServices->searchZones($keyword, $province, null);
        } else {
            $userLat = session('userLat');
            $userLng = session('userLng');

            if ($userLat && $userLng) {
                $zones = $this->zoneServices->searchZonesWithinRadius($userLat, $userLng, 30);
            } else {
                $zones = $this->zoneServices->getMyZoneClient();
            }
        }

        // $totalZones = $this->zoneServices->getTotalZones();
        $provinces = $this->zoneServices->getProvinces()->pluck('province')->toArray(); // Chuyển đổi Collection thành mảng

        if ($request->ajax()) {
            return response()->json([
                'zones' => $zones->items(),
                'totalZones' => $totalZones,
                'pagination' => (string) $zones->links()
            ]);
        }
        $usersWithRoleZero = $this->userClientServices->getUsersWithRoleZero();
        return view('client.show.about-us', [
            'zones' => $zones,
            // 'totalZones' => $totalZones,
            'keyword' => $keyword,
            'province' => $province,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'userLat' => $request->input('user_lat'),
            'userLng' => $request->input('user_lng'),
            'showLocationAlert' => true,
            'provinces' => $provinces,
            'zoneServices' => $this->zoneServices, // Truyền danh sách các mã tỉnh vào view
            'usersWithRoleZero' => $usersWithRoleZero
        ]);
        // return view('client.show.about-us');

    }
    // Giao diện Dịch Vụ
    public function showService()
    {
        return view('client.show.services');
    }
}
