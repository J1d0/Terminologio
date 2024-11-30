<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Vérifiez si l'utilisateur est connecté et a le rôle requis
        if (!$user || !$user->hasRole($role)) {
            // Redirigez ou gérez les utilisateurs non autorisés ici
            return redirect('home')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
