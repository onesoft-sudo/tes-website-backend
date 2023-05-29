<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\RequestWithTokenAuth;

class BearerTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return response([
                "error" => "No authorization header is present in the request"
            ], 400);
        }

        $authorization = explode(' ', $request->header('Authorization'));

        if ($authorization[0] !== 'Bearer') {
            return response([
                "error" => "Only bearer token authorization is supported"
            ], 400);
        }

        if (!array_key_exists(1, $authorization)) {
            return response([
                "error" => "No bearer token is present in the request"
            ], 400);
        }

        [, $token] = $authorization;

        /** @var User|null $user */
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response([
                "error" => "Invalid bearer token found in the request"
            ], 401);
        }

        return $next(RequestWithTokenAuth::createFrom($request)->setUser($user));
    }
}
