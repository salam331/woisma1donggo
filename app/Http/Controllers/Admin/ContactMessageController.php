<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = ContactMessage::paginate(10);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Contact messages are created from the public contact form, not from admin
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Contact messages are created from the public contact form, not from admin
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewed
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactMessage $contactMessage)
    {
        // Contact messages are not editable
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMessage $contactMessage)
    {
        // Contact messages are not editable, but we can mark as read/unread
        $request->validate([
            'is_read' => 'boolean',
        ]);

        $contactMessage->update($request->only('is_read'));

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
