<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfWeightNotSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // STEP2 以外のページにアクセスした時のみリダイレクト
        if (is_null($user->weight_init) && $request->route()->getName() !== 'register.step2') {
            return redirect()->route('register.step2');
        }

        return $next($request);
    }
}