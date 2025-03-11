<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'member_phone' => 'required',
            'photo' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // لفحص القيم المرسلة في الطلب
                    if (request()->hasFile('photo')) {
                        // إذا كانت صورة مرفوعة كملف
                        $file = $value;
                        if (!$file instanceof \Illuminate\Http\UploadedFile) {
                            $fail("The $attribute must be a valid file.");
                        }

                        // تحقق من امتداد الملف
                        // if (!in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg'])) {
                        //     $fail("The $attribute must be a file of type: jpeg, png, jpg.");
                        // }

                        // تحقق من حجم الملف
                        if ($file->getSize() > 2048 * 1024) { // 2MB
                            $fail("The $attribute must not exceed 2MB.");
                        }
                    } elseif (is_string($value) && preg_match('/^data:image\/(\w+);base64,/', $value)) {
                        // إذا كانت القيمة نصية (محتوى Base64)
                        if (!preg_match('/^data:image\/(jpeg|png|jpg);base64,/', $value)) {
                            $fail("The $attribute must be a file of type: jpeg, png, jpg.");
                        }
                    }
                },
            ],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
