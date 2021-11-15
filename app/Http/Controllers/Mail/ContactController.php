<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "message" => "required",
        ]);
        Mail::to(config("mail.to.address"))->send(
            new ContactMail($request["name"], $validated["email"], $validated["message"], $request["sender"], config("mail.from.address"))
        );
        return response()->json(null, 200);
    } //end submit()
}//end class
