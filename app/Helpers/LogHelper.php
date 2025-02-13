<?php

namespace App\Helpers;

use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function logActivity($message)
    {
        if (Auth::check()) {
            ActivityLogs::create([
                'user_id' => Auth::id(),
                'activity' => $message
            ]);
        }
    }
}
