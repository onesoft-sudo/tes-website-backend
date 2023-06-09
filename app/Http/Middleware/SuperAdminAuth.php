<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
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

        if ($token !== env('SUPER_ADMIN_PASSWORD')) {
            return response([
                "error" => "You're not allowed to perform this action"
            ], 403);
        }

        return $next($request);
    }
}
