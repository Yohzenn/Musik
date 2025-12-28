<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKeyHeader = $request->header('x-api-key');

        if (! $apiKeyHeader) {
            return response()->json(['error' => 'API key is required'], 401);
        }

        $apiKey = ApiKey::where('key', $apiKeyHeader)->first();

        if (! $apiKey) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $request->setUserResolver(fn () => $apiKey->user);

        return $next($request);
    }
}

