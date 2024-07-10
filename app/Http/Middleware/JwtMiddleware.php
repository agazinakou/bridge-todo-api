<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware

{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) throw new Exception('User Not Found');
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json([
                    'code' => 100,
                    'message' => 'Token Invalid'
                ]);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json([
                    'code' => 101,
                    'message' => 'Token Expired',
                ]);
            } else {
                if ($e->getMessage() === 'User Not Found') {
                    return response()->json([
                        'code' => 102,
                        "message" => "User Not Found",
                    ]);
                }
                return response()->json([
                    'code' => 103,
                    'message' => 'Authorization Token not found',
                ]);
            }
        }

        return $next($request);
    }
}
