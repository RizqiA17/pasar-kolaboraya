<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sharedSecret = config('services.api.shared_secret');
        $timestamp = $request->header('X-Timestamp');
        $signature = $request->header('X-Signature');

        // Validate timestamp exists and is not too old (max 2 minutes)
        if (! $timestamp || abs(time() - (int)$timestamp) > 120) {
            return response()->json([
                'status' => 'error',
                'message' => 'Expired or missing timestamp'
            ], 403);
        }

        // Generate expected signature
        $expected = hash_hmac('sha256', $timestamp . $request->getContent(), $sharedSecret);

        // Verify signature matches
        if (! hash_equals($expected, $signature ?? '')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature'
            ], 403);
        }

        return $next($request);
    }
}

