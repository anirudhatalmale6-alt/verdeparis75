<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VerdeAdminMessageMail;
use App\Models\VerdeMessage;
use App\Models\VerdeMessageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerdeMessageSettingController extends Controller
{
    public function edit()
    {
        return view('admin.messages.settings', [
            'redirect_emails' => VerdeMessageSetting::getValue('redirect_emails', env('VERDE_MESSAGES_DEFAULT_REDIRECT', '')),
            'client_confirmation' => VerdeMessageSetting::getValue('client_confirmation', '1'),
            'min_seconds' => VerdeMessageSetting::getValue('min_seconds', '3'),
            'admin_notification' => VerdeMessageSetting::getValue('admin_notification', '1'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'redirect_emails' => ['required', 'string', 'max:1000'],
            'client_confirmation' => ['nullable'],
            'admin_notification' => ['nullable'],
            'min_seconds' => ['required', 'integer', 'min:1', 'max:30'],
        ]);

        VerdeMessageSetting::setValue('redirect_emails', $data['redirect_emails']);
        VerdeMessageSetting::setValue('client_confirmation', $request->boolean('client_confirmation') ? '1' : '0');
        VerdeMessageSetting::setValue('admin_notification', $request->boolean('admin_notification') ? '1' : '0');
        VerdeMessageSetting::setValue('min_seconds', (string) $data['min_seconds']);

        return back()->with('success', 'Parametres enregistres.');
    }

    public function test()
    {
        $fake = new VerdeMessage([
            'name' => 'Test VERDE',
            'email' => 'test@verdeparis75.com',
            'phone' => '0661129432',
            'subject' => 'Test notification messagerie',
            'service' => 'Test',
            'message' => 'Ceci est un test de redirection email du module Messagerie Pro.',
            'source_page' => config('app.url'),
            'ip_address' => request()->ip(),
        ]);

        $emails = VerdeMessageSetting::redirectEmails();
        if (empty($emails)) {
            return back()->with('error', 'Aucun email de redirection configure.');
        }

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new VerdeAdminMessageMail($fake));
            }
            return back()->with('success', 'Email test envoye a: ' . implode(', ', $emails));
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}
