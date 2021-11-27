<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use App\Services\CacheService;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class VerifyAccessToken
{
    public function __construct(private CacheService $cacheService, private AuthService $authService)
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user === null || ! $this->cacheService->hasAccessToken($user)) {
            $this->authService->logout();
        }

        return $next($request);
    }
}
