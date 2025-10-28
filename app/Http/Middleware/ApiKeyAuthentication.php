<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');
        $apiSecret = $request->header('X-API-Secret');

        if (!$apiKey || !$apiSecret) {
            return response()->json([
                'status' => 'error',
                'message' => 'API Key and Secret required'
            ], 401);
        }

        $key = ApiKey::findByKey($apiKey);

        if (!$key || !$key->isValid()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired API key'
            ], 401);
        }

        // Verify secret
        if (!hash_equals($key->secret, $apiSecret)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API secret'
            ], 401);
        }

        // Mark as used
        $key->markAsUsed();

        // Add API key to request for logging
        $request->merge(['api_key' => $key]);

        return $next($request);
    }
}

