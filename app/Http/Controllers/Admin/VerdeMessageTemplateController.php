<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerdeMessageTemplate;
use Illuminate\Http\Request;

class VerdeMessageTemplateController extends Controller
{
    public function index()
    {
        $templates = VerdeMessageTemplate::latest()->get();
        return view('admin.messages.templates', compact('templates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string'],
            'is_default' => ['nullable'],
        ]);
        $data['is_default'] = $request->boolean('is_default');
        VerdeMessageTemplate::create($data);
        return back()->with('success', 'Modele ajoute.');
    }

    public function update(Request $request, VerdeMessageTemplate $template)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string'],
            'is_default' => ['nullable'],
        ]);
        $data['is_default'] = $request->boolean('is_default');
        $template->update($data);
        return back()->with('success', 'Modele modifie.');
    }

    public function destroy(VerdeMessageTemplate $template)
    {
        $template->delete();
        return back()->with('success', 'Modele supprime.');
    }
}
