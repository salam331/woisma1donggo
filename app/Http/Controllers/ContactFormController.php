<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    /**
     * Handle storing a new contact message from the public form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'phone'   => 'required|integer|max:20',
            'message' => 'required|string',
        ]);

        // Create ContactMessage record
        ContactMessage::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'subject' => $validated['subject'],
            'phone'   => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return redirect()->route('contact')->with('success', 'Pesan Anda telah terkirim. Terima kasih.');
    }
}
