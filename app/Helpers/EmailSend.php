<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class EmailSend
{
    public static function sendEmail($email, $status, $description){

        $data['email'] = $email;
        $data['title'] = 'Notifikasi Workorder Eye System';
        $data['status'] = $status;
        $data['description'] = $description;

        Mail::send('pages.email.email', ['data' => $data], function($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });
    }
}
