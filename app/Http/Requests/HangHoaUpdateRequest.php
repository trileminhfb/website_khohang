<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HangHoaUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'ten_hang_hoa' => 'required|max:255',
            'ma_hang_hoa' => 'required|max:100',
            'id_loai_hang' => 'required|integer',
            'don_vi_tinh' => 'required|max:50',
            'change_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'barcode' => ['nullable', 'string', 'max:20', 'regex:/^[A-Z0-9]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'ten_hang_hoa.required' => 'Tên hàng hóa không được bỏ trống.',
            'ten_hang_hoa.max' => 'Tên hàng hóa không được vượt quá :max ký tự.',
            'ma_hang_hoa.required' => 'Mã hàng hóa không được bỏ trống.',
            'ma_hang_hoa.max' => 'Mã hàng hóa không được vượt quá :max ký tự.',
            'id_loai_hang.required' => 'Vui lòng chọn loại hàng.',
            'id_loai_hang.integer' => 'Loại hàng phải là số nguyên.',
            'don_vi_tinh.required' => 'Đơn vị tính không được bỏ trống.',
            'don_vi_tinh.max' => 'Đơn vị tính không được vượt quá :max ký tự.',
            'change_img.image' => 'File không đúng định dạng hình ảnh.',
            'change_img.mimes' => 'Định dạng hình ảnh không hỗ trợ. Chỉ chấp nhận các định dạng: jpeg, png, jpg, gif, svg.',
            'change_img.max' => 'Kích thước hình ảnh không được vượt quá :max KB.',
            'barcode.max' => 'Mã vạch không được vượt quá :max ký tự.',
            'barcode.integer' => 'Mã vạch phải là số nguyên.',
            'barcode.regex' => 'Mã vạch không hợp lệ. Vui lòng kiểm tra lại.'
        ];
    }
}
