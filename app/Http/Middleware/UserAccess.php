<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
  public function handle(Request $request, Closure $next, $userType): Response
{
    if (Auth::check() && strtoupper(Auth::user()->role) == strtoupper($userType)) {
        return $next($request);
    }

    abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
}
}