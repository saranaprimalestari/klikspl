<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Arrays;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        // dd($request);
        // echo $request->email;
        
        $details = [
            'id' => $request->id,
            'title' => $request->title,
            'body' => $request->message,
            'url' => $request->url,
            'verification' => $request->verifCode,
            'closing' => $request->closing,
            'footer' => $request->footer,
        ];
        Mail::to($request->email)->send(new \App\Mail\mailSystem($details));
        // dd('email sent');
    }
}
