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

    /**
     * Check if connections are enabled
     */
    public static function isConnectionsEnabled()
    {
        return static::getValue('connections_enabled', '1') === '1';
    }

    /**
     * Enable or disable connections
     */
    public static function setConnectionsStatus($enabled)
    {
        return static::setValue(
            'connections_enabled',
            $enabled ? '1' : '0',
            'Controls whether users can create and manage connections'
        );
    }

    /**
     * Check if collaborations are enabled
     */
    public static function isCollaborationsEnabled()
    {
        return static::getValue('collaborations_enabled', '1') === '1';
    }

    /**
     * Enable or disable collaborations
     */
    public static function setCollaborationsStatus($enabled)
    {
        return static::setValue(
            'collaborations_enabled',
            $enabled ? '1' : '0',
            'Controls whether users can create and manage collaborations'
        );
    }

    /**
     * Check if user actions are enabled
     */
    public static function isUserActionsEnabled()
    {
        return static::getValue('user_actions_enabled', '1') === '1';
    }

    /**
     * Enable or disable user actions
     */
    public static function setUserActionsStatus($enabled)
    {
        return static::setValue(
            'user_actions_enabled',
            $enabled ? '1' : '0',
            'Controls whether users can perform actions like joining events, etc.'
        );
    }
}
