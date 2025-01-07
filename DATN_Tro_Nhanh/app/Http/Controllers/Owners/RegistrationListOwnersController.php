<?php

namespace App\Http\Controllers\Owners;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RegistrationService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class RegistrationListOwnersController extends Controller
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function storeData(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cmnd_number' => 'required|string',
                'full_name' => 'required|string',
                'gender' => 'required|string',
                'issued_by' => 'required|string',
            ]);

            // Chuyển đổi giá trị giới tính từ văn bản thành số
            $gender = $validatedData['gender'];
            switch (strtolower($gender)) {
                case 'nam':
                    $gender = 1;
                    break;
                case 'nữ':
                    $gender = 2;
                    break;
                default:
                    $gender = null; // Hoặc xử lý lỗi nếu giá trị không phải 'nam' hoặc 'nữ'
                    break;
            }

            $imagePaths = session()->get('image_paths', []);

            $data = [
                'identification_number' => $validatedData['cmnd_number'],
                'name' => $validatedData['full_name'],
                'gender' => $gender,
                'description' => $validatedData['issued_by'],
                'user_id' => auth()->id(),
            ];

            $images = [
                'cccdmt_filename' => $imagePaths['cccdmt_filename'] ?? null,
                'cccdms_filename' => $imagePaths['cccdms_filename'] ?? null,
                'fileface_filename' => $imagePaths['fileface_filename'] ?? null,
            ];

            // Đảm bảo registrationService được khởi tạo đúng cách
            if (is_null($this->registrationService)) {
                throw new \Exception('RegistrationService không được khởi tạo.');
            }

            $this->registrationService->saveRegistrationData($data, $images);

            return redirect()->back()->with('success', 'Dữ liệu và hình ảnh đã được lưu thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi lưu dữ liệu và hình ảnh: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi lưu dữ liệu.');
        }
    }

    public function submitRequest(Request $request)
    {
        $validated = $request->validate([
            'identity_id' => 'required|string',
            'reason' => 'required|string',
        ]);

        // Sử dụng service để xử lý dữ liệu
        $this->registrationService->createRequest($validated);

        return redirect()->back()->with('success', 'Yêu cầu của bạn đã được gửi thành công.');
    }

    public function store(Request $request)
    {
        // Kiểm tra xem registrationService có được inject thành công không
        if ($this->registrationService) {
            // Nếu có, gọi phương thức handleRegistration từ service

            return $this->registrationService->handleRegistration($request);
        } else {
            // Nếu không, trả về lỗi hoặc thông báo rằng service không được inject
            return redirect()->back()->with(['error' => 'Đã xảy ra lỗi, dịch vụ không được khởi tạo thành công.']);
        }
    }
}
