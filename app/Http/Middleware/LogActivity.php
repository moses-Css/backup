<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $activity = "Mengakses " . $request->path();
            ActivityLogs::create([
                'user_id' => Auth::id(),
                'activity' => $activity,
            ]);
        }
        return $next($request);
    }
}
