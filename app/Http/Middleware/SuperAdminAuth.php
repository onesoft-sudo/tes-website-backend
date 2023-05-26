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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            "super_token" => 'required|string'
        ]);

        if ($request->super_token !== env('SUPER_ADMIN_PASSWORD')) {
            return response([
                "error" => "You're not allowed to perform this action"
            ], 403);
        }

        return $next($request);
    }
}
