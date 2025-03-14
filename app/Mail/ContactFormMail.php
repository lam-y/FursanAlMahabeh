<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->messageData = [
            'name' => $message->name,
            'email' => $message->email,
            'phone' => $message->phone,
            'birthdate' => $message->birthdate,
            'school' => $message->school,
            'grade' => $message->grade->name ?? 'غير محدد',
            'message' => $message->message,
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Info@fursanalmahabeh.sy')
                    ->subject('رسالة جديدة إلى موقع فرسان المحبة')
                    ->view('emails.contact') // عرض HTML للبريد
                    ->with(['messageData' => $this->messageData]);
    }
}
