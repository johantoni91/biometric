<?php

namespace App\Helpers;

class Icon
{
    public static function get($name)
    {
        $icons = [
            'dashboard' => 'dashboard',
            'users' => 'people',
            'settings' => 'settings',
            'reports' => 'bar_chart',
            'notifications' => 'notifications',
            // Add more icons as needed
        ];

        return $icons[$name] ?? 'help_outline'; // Default icon if not found
    }
}
