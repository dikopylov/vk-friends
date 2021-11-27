<?php

declare(strict_types=1);


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use VK\OAuth\Scopes\VKOAuthUserScope;
use function back;
use function redirect;

class VKAuthController extends Controller
{
    private const DRIVER = 'vkontakte';

    public function __construct(private AuthService $authService)
    {
    }

    public function verify()
    {
        $user = $this->authService->auth(Socialite::driver(self::DRIVER)->user());

        if ($user) {
            return redirect()->to('/');
        }

        return back();
    }

    public function auth(): RedirectResponse
    {
        return Socialite::driver(self::DRIVER)
            ->scopes(['friends'])
            ->redirect();
    }
}
