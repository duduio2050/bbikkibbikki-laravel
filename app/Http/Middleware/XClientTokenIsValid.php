<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XClientTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('X-Client-Token') == null || $request->header('X-Client-Token') != "qwer123") {
            return response()->json([
                "error" => "no xclient_token"
            ], 403);
        }

        return $next($request);
    }
}
