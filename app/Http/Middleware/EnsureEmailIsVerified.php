<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class EnsureEmailIsVerified
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
        //校验用户登录 未认证
        if ($request->user()
         &&! $request->user()->hasVerifiedEmail()
            && !$request->is('email/*', 'logout')) {
            return $request->expectsJson() ? abort(403, 'Your email address is not verified') : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
