<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Send the email using the ContactMessage mailable
        Mail::to(config('mail.from.address'))->send(new ContactMessage($validated));

        // Return back with success message
        return back()->with('success', 'Message sent successfully!');
    }
}
