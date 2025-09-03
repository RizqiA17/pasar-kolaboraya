<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description'
    ];

    /**
     * Get a system setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a system setting value by key
     */
    public static function setValue($key, $value, $description = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description
            ]
        );
    }

    /**
     * Check if login is enabled
     */
    public static function isLoginEnabled()
    {
        return static::getValue('login_enabled', '1') === '1';
    }

    /**
     * Enable or disable login
     */
    public static function setLoginStatus($enabled)
    {
        return static::setValue(
            'login_enabled',
            $enabled ? '1' : '0',
            'Controls whether users can login to the system'
        );
    }
}
