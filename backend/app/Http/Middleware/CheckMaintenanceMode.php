<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemSetting;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $maintenance = SystemSetting::where('key', 'maintenance_mode')->first();
            if ($maintenance && $maintenance->value === 'true') {
                return response()->json(['message' => 'Application is under maintenance.'], 503);
            }
        } catch (\Exception $e) {
            // If table doesn't exist yet, skip check
        }

        return $next($request);
    }
}
