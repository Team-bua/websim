<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' =>'required|max:50|regex:/(^[\pL0-9 ]+$)/u',
            'email' =>'required|email|max:100|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' =>'required|max:25|min:5',
            'confirm_password' => 'required|same:password',
            'checkbox' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Giới hạn 50 ký tự',
            'name.regex' => 'Tên không được có ký tự đặc biệt',
            'email.required' => 'Vui lòng nhập email',
            'email.max' => 'Email không vượt quá 100 ký tự',
            'email.email' => 'Định dạng email không đúng',
            'email.unique' => 'Email đã tồn tại',
            'phone.required' => 'Vui lòng nhập số điện thoại',    
            'phone.numeric' => 'Số điện thoại không đúng định dạng: 094382746',
            'phone.unique' => 'Số điện thoại đã tồn tại',  
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.max' => 'Giới hạn 25 ký tự',
            'password.min' => 'Thấp nhất 5 ký tự',
            'confirm_password.required' => 'Vui lòng nhập lại mật khẩu',
            'confirm_password.same' => 'Xác nhận mật khẩu không chính xác',
            'checkbox.required' => 'Vui lòng đồng ý điều khoản',
        ];
    }
}
