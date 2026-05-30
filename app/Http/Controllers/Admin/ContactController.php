<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages with optional read/unread filter.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        // Filter by read status
        if ($request->has('filter')) {
            match ($request->input('filter')) {
                'unread' => $query->unread(),
                'read' => $query->where('is_read', true),
                default => null,
            };
        }

        $messages = $query->paginate(15);

        $unreadCount = ContactMessage::unread()->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified contact message and mark it as read.
     */
    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);

            AdminLog::log('read', $message, [
                'from' => $message->name,
                'subject' => $message->subject,
            ]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        AdminLog::log('deleted', $message, [
            'from' => $message->name,
            'subject' => $message->subject,
        ]);

        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }
}
