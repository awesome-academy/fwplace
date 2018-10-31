<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $editUser = User::findOrFail($request->route()->parameters('id'));
            $users = Auth::user();
            if ($users == $editUser[0]) {
                return $next($request);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect('register');
        }
    }
}
