<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');

        if (!$token) {
            return response()->json([
                'error' => 'Geen token opgegeven.'
            ], 401);
        }

        try {
            JWT::decode($token, env('APP_KEY'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Opgegeven token is verlopen.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fout bij ontsleutelen token.',
                'exception' => $e
            ], 400);
        }

        return $next($request);
    }
}
