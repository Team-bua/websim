<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'bank_name' => 'required|max:150',        
            'bank_image' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'bank_number' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => 'Vui lòng nhập tên tài khoản',
            'bank_name.max' => 'Giới hạn 150 ký tự',
            'bank_image.mimes' => 'Chỉ gắn thẻ hình ảnh có đuôi .jpg .jpeg .png .gif',
            'bank_image.max' => 'Giới hạn ảnh 2Mb',
            'bank_number.required' => 'Vui lòng nhập số tài khoản',
            'bank_number.numeric' => 'Giá trị nhập phải là số',
        ];
    }
}
