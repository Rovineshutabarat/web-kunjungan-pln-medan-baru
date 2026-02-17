<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
   public function handle($request, Closure $next)
{
    if (!Session::get('petugas_login')) {
        return redirect('/login-petugas');
    }

    return $next($request);
}



}
