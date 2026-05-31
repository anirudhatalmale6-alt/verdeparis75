<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VerdeAdminReplyMail;
use App\Models\AdminLog;
use App\Models\VerdeMessage;
use App\Models\VerdeMessageTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerdeMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = VerdeMessage::query();

        if ($request->status === 'unread') $query->unread();
        elseif ($request->status === 'archived') $query->where('is_archived', true);
        elseif ($request->status === 'spam') $query->where('is_spam', true);
        else $query->inbox();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($s) use ($q) {
                $s->where('name', 'like', "%$q%")
                  ->orWhere('email', 'like', "%$q%")
                  ->orWhere('phone', 'like', "%$q%")
                  ->orWhere('subject', 'like', "%$q%")
                  ->orWhere('message', 'like', "%$q%");
            });
        }

        $messages = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => VerdeMessage::count(),
            'unread' => VerdeMessage::where('is_read', false)->where('is_spam', false)->count(),
            'archived' => VerdeMessage::where('is_archived', true)->count(),
            'spam' => VerdeMessage::where('is_spam', true)->count(),
        ];

        return view('admin.messages.index', compact('messages', 'stats'));
    }

    public function show(VerdeMessage $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true, 'read_at' => now()]);
            AdminLog::log('read', $message, ['from' => $message->name]);
        }
        $templates = VerdeMessageTemplate::latest()->get();
        return view('admin.messages.show', compact('message', 'templates'));
    }

    public function markRead(VerdeMessage $message)
    {
        $message->update(['is_read' => true, 'read_at' => now()]);
        return back()->with('success', 'Message marque comme lu.');
    }

    public function markUnread(VerdeMessage $message)
    {
        $message->update(['is_read' => false, 'read_at' => null]);
        return back()->with('success', 'Message marque comme non lu.');
    }

    public function archive(VerdeMessage $message)
    {
        $message->update(['is_archived' => true]);
        AdminLog::log('updated', $message, ['action' => 'archived']);
        return back()->with('success', 'Message archive.');
    }

    public function restore(VerdeMessage $message)
    {
        $message->update(['is_archived' => false, 'is_spam' => false]);
        return back()->with('success', 'Message restaure.');
    }

    public function destroy(VerdeMessage $message)
    {
        AdminLog::log('deleted', $message, ['from' => $message->name]);
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message supprime.');
    }

    public function reply(Request $request, VerdeMessage $message)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string', 'min:5'],
        ]);

        try {
            Mail::to($message->email)->send(new VerdeAdminReplyMail($message, $data['subject'], $data['body']));
            $message->update(['replied_at' => now(), 'is_read' => true, 'read_at' => $message->read_at ?: now()]);
            AdminLog::log('updated', $message, ['action' => 'replied']);
            return back()->with('success', 'Reponse envoyee au client.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi: ' . $e->getMessage());
        }
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'action' => ['required', 'in:read,unread,archive,delete,spam'],
        ]);

        $messages = VerdeMessage::whereIn('id', $data['ids']);
        match ($data['action']) {
            'read' => $messages->update(['is_read' => true, 'read_at' => now()]),
            'unread' => $messages->update(['is_read' => false, 'read_at' => null]),
            'archive' => $messages->update(['is_archived' => true]),
            'spam' => $messages->update(['is_spam' => true]),
            'delete' => $messages->delete(),
        };

        return back()->with('success', 'Action groupee effectuee.');
    }
}
