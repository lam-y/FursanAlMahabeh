<?php

namespace App\Http\Controllers\API;

use App\Traits\APIResponse;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\MessageRequest;

class ContactUsController extends Controller
{
    use APIResponse;

    public function sendMessage(MessageRequest $request)
    {
        DB::beginTransaction();
        try {
            $message = ContactMessage::create([
                            'name' => $request->name,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'birthdate' => $request->birthdate,
                            'school' => $request->school,
                            'grade_id' => $request->grade,
                            'message' => $request->message,
                        ]);

            Mail::to('info@fursanalmahabeh.sy')->send(new ContactFormMail($message));

            DB::commit();
            return $this->createAPIResponse(true, null, 'تم إرسال الرسالة بنجاح.. سيتم التواصل معك قريباً');

        }catch (Exception $e) {
            DB::rollBack();
            \Log::error("Contact Form Error: " . $e->getMessage());
            return $this->createAPIResponse(false, null, 'حدث خطأ أثناء ارسال الرسالة!');
        }

    }
}
