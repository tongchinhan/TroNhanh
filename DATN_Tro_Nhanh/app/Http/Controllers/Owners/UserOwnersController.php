<?php

namespace App\Http\Controllers\Owners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserClientServices;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use App\Services\RegistrationService;
use Illuminate\Support\Facades\Auth;
use App\Models\Identity;
use App\Models\Registrationlist;
use App\Models\Image;
use App\Services\ImageAdminService;
use Illuminate\Support\Facades\Log;
class UserOwnersController extends Controller
{
    protected $userClientServices;
    protected $profileService;
    protected $registrationService;
    protected $imageAdminService;
    public function __construct(UserClientServices $userClientServices, ProfileService $profileService, RegistrationService $registrationService, ImageAdminService $imageAdminService)
    {
        $this->userClientServices = $userClientServices;
        $this->profileService = $profileService;
        $this->registrationService = $registrationService;
        $this->imageAdminService = $imageAdminService;
    }
    // Hiển thị giao diện Thông tin tài khoản Admin
    public function indexProfileAdmin()
    {
        // Lấy thông tin người dùng hiện tại từ service bằng slug
        $user = $this->profileService->getUserById(Auth::user()->slug);

        // Trả về view cùng với dữ liệu người dùng
        return view('owners.profile.dashboard-my-profiles', compact('user'));
    }



    public function updateProfile(UpdateProfileRequest $request, $id)
    {
        try {
            
            $data = $request->validated();
            Log::info($data);
            $result = $this->profileService->updateProfileBySlug($id, $data);

            if (is_array($result) && isset($result['success'])) {
                return response()->json($result, $result['success'] ? 200 : 400);
            } else {
                // Xử lý trường hợp $result không phải là mảng
                return response()->json(['success' => false, 'message' => 'Kết quả không hợp lệ.'], 400);
            }
            // return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ], 500);
        }
    }


    public function indexResetPassWordAdmin()
    {
        return view('owners.profile.page-reset-password-admin');
    }
    public function page_dashboard()
    {
        return view('owners.show.dashboard');
    }
    public function changePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        // Nếu có lỗi, phương thức validateWithBag sẽ tự động chuyển hướng về trang trước đó với thông báo lỗi
        $validated = $request->validated();

        // Nếu không có lỗi, tiếp tục gọi hàm đổi mật khẩu trong PasswordService
        $this->userClientServices->changePassword($request);

        return redirect()->route('owners.profile.profile-admin-index')->with('status', __('Mật khẩu đã được cập nhật thành công.'));
    }
    public function page_register_owner()
    {
        $userId = auth()->id();
        $registrationStatus = $this->registrationService->getRegistrationStatus($userId);

        return view('owners.create.register_owner', $registrationStatus);
    }

    public function page_resigter_ekyc()
    {
        $userId = auth()->id();
        $identity = Identity::where('user_id', $userId)->first();
        $isRegistered = !is_null($identity);
        return view('owners.create.register_ekyc', compact('isRegistered', 'identity'));
    }

    public function information_page_ekyc()
    {
        $userId = auth()->id();
        $information = Identity::where('user_id', $userId)->first();
        $images = [];
    
        if ($information) {
            if ($information->front_id_card_image) {
                $images[] = $information->front_id_card_image;
            }
            if ($information->back_id_card_image) {
                $images[] = $information->back_id_card_image;
            }
        }
    
        return view('owners.show.dashboard-ekyc', compact('information', 'images'));
    }
    public function toggleVisibility()
    {
        $userId = auth()->id();
        $identity = Identity::where('user_id', $userId)->first();

        if ($identity) {
            $identity->status = $identity->status == 1 ? 2 : 1;
            $identity->save();

            $message = $identity->status == 2 ? 'Thông tin đã được công khai.' : 'Thông tin đã được ẩn.';
            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'Không tìm thấy thông tin để thay đổi trạng thái.');
    }

    public function clear_information()
{
    $userId = auth()->id();
    $identity = Identity::where('user_id', $userId)->first();

    if ($identity) {
        // Lấy đường dẫn hình ảnh từ các cột front_id_card_image và back_id_card_image
        $images = [];
        if ($identity->front_id_card_image) {
            $images[] = $identity->front_id_card_image;
        }
        if ($identity->back_id_card_image) {
            $images[] = $identity->back_id_card_image;
        }

        // Xóa hình ảnh trong thư mục
        foreach ($images as $image) {
            $imagePath = public_path('path/to/images/' . $image); // Cập nhật đường dẫn đúng
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Xóa thông tin của người dùng
        $deleted = $identity->forceDelete();

        // Nếu xóa thành công
        if ($deleted) {
            return redirect()->back()->with('success', 'Xóa thông tin thành công!');
        }
    }

    // Nếu không có bản ghi nào bị xóa
    return redirect()->back()->with('error', 'Không tìm thấy thông tin để xóa.');
}
}
