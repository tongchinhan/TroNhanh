<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateroomRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'phone' => 'required|string|max:20|regex:/^0[0-9]{9}$/',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'acreage' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'view' => 'required|integer|min:0',
          
            'user_id' => 'required|integer|exists:users,id',
            'category_id' => 'required|integer|exists:categories,id',
        //    'images' => 'required|array|min:1', // Ensure at least one image is uploaded
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',

            'description.required' => 'Vui lòng nhập mô tả',
            'description.string' => 'Mô tả phải là chuỗi ký tự',

            'price.required' => 'Vui lòng nhập giá',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được âm',

            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
            'phone.regex' => 'Không đúng định dạng số điện thoại.',

            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',

            'province.required' => 'Vui lòng chọn tỉnh/thành phố',

            'district.required' => 'Vui lòng chọn quận/huyện',

            'village.required' => 'Vui lòng chọn xã/phường',

            'acreage.required' => 'Vui lòng nhập diện tích',
            'acreage.integer' => 'Diện tích phải là số nguyên',
            'acreage.min' => 'Diện tích phải lớn hơn 0',

            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'quantity.min' => 'Số lượng phải lớn hơn 0',

            'longitude.required' => 'Vui lòng nhập kinh độ',
            'longitude.numeric' => 'Kinh độ phải là số',

            'latitude.required' => 'Vui lòng nhập vĩ độ',
            'latitude.numeric' => 'Vĩ độ phải là số',

            'view.required' => 'Vui lòng nhập số lượng view',
            'view.integer' => 'Số lượng view phải là số nguyên',
            'view.min' => 'Số lượng view không được âm',

            'user_id.required' => 'Vui lòng chọn người dùng',
            'user_id.exists' => 'Người dùng không tồn tại',

            'category_id.required' => 'Vui lòng chọn loại phòng',
            'category_id.exists' => 'Loại phòng không tồn tại',

            // 'bathrooms.required' => 'Vui lòng nhập số lượng phòng tắm',
            'bathrooms.integer' => 'Số lượng phòng tắm phải là số nguyên',
            'bathrooms.min' => 'Số lượng phòng tắm không được âm',

            // 'images.required' => 'Vui lòng tải lên ít nhất một hình ảnh.',
            'images.array' => 'Hình ảnh phải là một mảng.',
            'images.min' => 'Bạn phải tải lên ít nhất một hình ảnh.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, hoặc jpg.',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
    }
}
