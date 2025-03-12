<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MessageRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => null,
            'errors'    => $validator->errors()
        ]));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => 'required|numeric|regex:/^((09)[0-9\s\-\+\(\)]*)$/|digits:10',
            'email' => 'required|email',
            'birthdate' => 'required',
            'grade' => 'required',
            'message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'phone.required' => 'رقم الموبايل مطلوب',
            'phone.numeric' => 'أدخل رقم الموبايل بشكل صحيح',
            'phone.regex' => 'أدخل رقم الموبايل بشكل صحيح',
            'email.required' => 'الايميل مطلوب',
            'email.email' => 'أدخل الايميل بالشكل الصحيح',
            'birthdate.required' => 'حدد تاريخ الميلاد',
            'grade.required' => 'الصف الدراسي مطلوب',
            'message.required' => 'لم تقم بإدخال الرسالة',
        ];
    }
}
