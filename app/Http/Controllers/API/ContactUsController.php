<?php

namespace App\Http\Controllers\API;

use App\Traits\APIResponse;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;

class ContactUsController extends Controller
{
    use APIResponse;

    public function sendMessage(MessageRequest $request)
    {
        DB::beginTransaction();
        try {
            ContactMessage::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'birthdate' => $request->birthdate,
                'school' => $request->school,
                'grade_id' => $request->grade,
                'message' => $request->message,
            ]);

            DB::commit();
            return $this->createAPIResponse(true, null, 'تم إرسال الرسالة بنجاح.. سيتم التواصل معك قريباً');

        }catch (Exception $e) {
            DB::rollBack();
            \Log::error("Contact Form Error: " . $e->getMessage());
            return $this->createAPIResponse(false, null, 'حدث خطأ أثناء ارسال الرسالة!');
        }

    }
}
