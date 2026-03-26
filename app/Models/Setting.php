<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $fillable = ['key', 'value'];

    // Retrieve a setting value by key, returning $default if not found.
    public static function get(string $key, string $default = ''): string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    // Upsert a setting value by key.
    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
