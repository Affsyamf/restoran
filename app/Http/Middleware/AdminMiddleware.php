<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil user yang sedang login
        $user = $request->user();

        // Cek apakah user ada (tidak null) DAN apakah dia seorang admin
        if ($user && $user->isAdmin()) {
            return $next($request);
        }
        
        // Jika tidak, tolak aksesnya
        abort(403);
    }
}
