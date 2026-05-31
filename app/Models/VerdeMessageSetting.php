<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerdeMessageSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => is_array($value) ? json_encode($value) : $value]);
    }

    public static function redirectEmails(): array
    {
        $raw = static::getValue('redirect_emails', env('VERDE_MESSAGES_DEFAULT_REDIRECT', ''));
        return collect(explode(',', (string) $raw))
            ->map(fn($email) => trim($email))
            ->filter(fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }
}
