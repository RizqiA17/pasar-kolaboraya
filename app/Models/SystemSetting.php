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

    /**
     * Check if ecosystems are enabled (follows collaboration setting)
     * Ecosystem builders always have access regardless of collaboration setting
     * All user types can access ecosystems if not disabled by admin
     */
    public static function isEcosystemsEnabled($user = null)
    {
        // If no user provided, use authenticated user
        if (!$user && \Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
        }
        
        // Ecosystem builders always have access
        if ($user && $user->isEcosystemBuilder()) {
            return true;
        }
        
        // Otherwise follow collaboration setting
        return static::isCollaborationsEnabled();
    }

    /**
     * Check if collective actions are enabled (follows user actions setting)
     * All user types can access collective actions if not disabled by admin
     */
    public static function isCollectiveActionsEnabled($user = null)
    {
        // If no user provided, use authenticated user
        if (!$user && \Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
        }
        
        return static::isUserActionsEnabled();
    }

    /**
     * Check if a feature is enabled by cascading rules
     * Ecosystem follows collaboration, Collective Action follows user actions
     * Supports user-specific access (e.g., ecosystem builders)
     */
    public static function isFeatureEnabled($feature, $user = null)
    {
        switch ($feature) {
            case 'ecosystems':
                return static::isEcosystemsEnabled($user);
            case 'collective_actions':
                return static::isCollectiveActionsEnabled();
            case 'collaborations':
                return static::isCollaborationsEnabled();
            case 'connections':
                return static::isConnectionsEnabled();
            case 'user_actions':
                return static::isUserActionsEnabled();
            default:
                return false;
        }
    }
}
