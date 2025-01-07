<?php

namespace App\Http\Controllers\Owners;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Services\MaintenanceRequestsServices;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;
use App\Http\Requests\MaintenanceRequest;



class MaintenanceRequestOwnersController extends Controller
{
    protected $MaintenanceRequestsServices;

    public function __construct(MaintenanceRequestsServices $MaintenanceRequestsServices)
    {
        $this->MaintenanceRequestsServices = $MaintenanceRequestsServices;
    }
    public function show($roomId = null)
    {
        // Gọi phương thức để lấy yêu cầu bảo trì với hoặc không có roomId
        $maintenanceRequests = $this->MaintenanceRequestsServices->getAllMaintenanceRequests($roomId);

        // Truyền dữ liệu đến view
        return view('owners.show.dashboard-my-maintenance', compact('maintenanceRequests'));
    }
    public function showowner($roomId = null)
    {
        // Gọi phương thức để lấy yêu cầu bảo trì với hoặc không có roomId
        // $maintenanceRequests = $this->MaintenanceRequestsServices->getAllMaintenanceRequests($roomId);

        // Truyền dữ liệu đến view
        return view('owners.show.dashboard-owner-maintenance');
    }

    public function destroy($id)
    {
        $this->MaintenanceRequestsServices->softDeleteMaintenances($id);
        return redirect()->route('owners.trash-maintenances')->with('success', 'Phòng bảo trì đã được chuyển vào thùng rác.');
    }


    public function trash()
    {
        $trashedMaintenances = $this->MaintenanceRequestsServices->getTrashedMaintenances();
        return view('owners.trash.trash-maintenance', compact('trashedMaintenances'));
    }

    public function restore($id)
    {
        $this->MaintenanceRequestsServices->restoreMaintenances($id);
        return redirect()->route('owners.list-owner-fix')->with('success', 'Phòng bảo trì đã được khôi phục.');
    }

    public function sent_for_maintenance(MaintenanceRequest $request)
    {

        // dd($request->all()); 
        if (Auth::check()) {
            $user_id  = Auth::id();
            $this->MaintenanceRequestsServices->store($request, $user_id);
            return response()->json(['success' => true, 'message' => 'Đơn đã được gửi']);
        }
        return response()->json(['success' => false, 'error' => 'Bạn chưa đăng nhập'], 401);
    }
    public function finish($id)
    {
        $finish = 2;
        $result = $this->MaintenanceRequestsServices->editStatus($id, $finish);
        if ($result) {
            return back()->with('success', 'Hoàn thành.');
        } else {
            return back()->with('error', 'Không thành công.');
        }
    }
}
