<?php

namespace App\Http\Requests\order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_avatar' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'service_name' => 'required|max:190',
            'service_price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'service_avatar.mimes' => 'Chỉ gắn thẻ hình ảnh có đuôi .jpg .jpeg .png .gif được chấp nhận',
            'service_avatar.max' => 'Giới hạn ảnh 2Mb',
            'service_name.required' => 'Tên dịch vụ không được để trống',
            'service_name.max' => 'Giới hạn 190 ký tự',
            'service_price.required' => 'Vui lòng nhập giá tiền',
            'service_price.numeric' => 'Gía tiền không đúng định dạng số',
        ];
    }
}
