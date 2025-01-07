<?php

namespace App\Services;

use App\Models\PriceList;
use App\Models\Location;

class PriceListService
{

    public const Nangcaptaikhoan = 1;
    public const Hoatdong = 1;
    
    public function getLocations()
    {
        return Location::where('status', self::Hoatdong)->get();
    }
    public function createPriceList(array $data)
    {
        return PriceList::create($data);
    }

    public function getAllPriceLists($perPage = 10)
    {
        return PriceList::where('status', self::Nangcaptaikhoan) // Thêm điều kiện where
                 ->orderBy('created_at', 'desc') // Sắp xếp theo 'created_at'
                 ->paginate($perPage); // Phân trang với số lượng bản ghi trên mỗi trang là $perPage
    }


    public function getPriceListById($id)
    {
        return PriceList::findOrFail($id);
    }

    public function updatePriceList($id, array $data)
    {
        $priceList = PriceList::findOrFail($id);
        $priceList->update($data);
        return $priceList;
    }
 
    public function softDeletePriceList($id)
    {
        // Tìm gói tin theo ID
        $priceList = PriceList::findOrFail($id);

        // Kiểm tra xem location_id có tồn tại trong bảng location chưa bị xóa mềm không
        $hasActiveLocation = Location::where('id', $priceList->location_id)->whereNull('deleted_at')->exists();

        if ($hasActiveLocation) {
            // Nếu location còn hoạt động, trả về thông báo lỗi
            return [
                'status' => 'error',
                'message' => 'Không thể xóa vị trí tin do gói tin còn hoạt động.'
            ];
        }

        // Nếu không có location đang hoạt động, tiến hành xóa mềm
        $priceList->delete();

        // Trả về thông báo thành công
        return [
            'status' => 'success',
            'message' => 'Gói tin đã được chuyển vào thùng rác thành công.'
        ];
    }

    public function getTrashedPriceLists()
    {
        return PriceList::onlyTrashed()->get();
    }

    public function restorePriceList($id)
    {
        $priceList = PriceList::withTrashed()->findOrFail($id);
        $priceList->restore();
        return $priceList;
    }
    
    public function forceDeletePriceList($id)
    {
        $priceList = PriceList::withTrashed()->findOrFail($id);

        // Kiểm tra xem location_id có tồn tại trong bảng location chưa bị xóa mềm không
        $hasActiveLocation = Location::where('id', $priceList->location_id)->whereNull('deleted_at')->exists();

        if ($hasActiveLocation) {
            return [
                'status' => 'error',
                'message' => 'Không thể xóa vị trí tin do gói tin còn hoạt động.'
            ];
        }

        $priceList->forceDelete();
        return [
            'status' => 'success',
            'message' => 'Gói tin đã được xóa vĩnh viễn.'
        ];
    }
}
