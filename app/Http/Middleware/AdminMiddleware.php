<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Nëse përdoruesi është i loguar dhe është Admin (is_admin == 1)
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Lejo qasjen në faqe
        }

        // Nëse nuk është admin, ktheje te faqja kryesore me mesazh gabimi
        return redirect('/')->with('error', 'Nuk keni qasje si Admin.');
    }
}