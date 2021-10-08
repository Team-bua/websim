<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:2048',
            'name' => 'required|max:50|regex:/(^[\pL0-9 ]+$)/u',
            'phone' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'avatar.mimes' => 'Chỉ gắn thẻ hình ảnh có đuôi .jpg .jpeg .png .gif are accepted',
            'avatar.max' => 'Giới hạn ảnh 2Mb',
            'name.regex' => 'Tên không được có ký tự đặc biệt',
            'name.max' => 'Giới hạn 50 ký tự',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại không đúng định dạng: 094382746',
        ];
    }
}
