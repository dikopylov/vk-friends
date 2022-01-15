<?php

namespace App\Providers;

use App\Factories\EloquentUserFactory;
use App\Factories\UserFactoryInterface;
use App\Vk\Clients\FriendsClient;
use App\Vk\Clients\VKClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const ELOQUENT = 'eloquent';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bindings();
    }

    /**
     * @return bool
     */
    private function isEloquentUser(): bool
    {
        return config('auth.providers.users.driver') === self::ELOQUENT;
    }

    private function bindings(): void
    {
        if ($this->isEloquentUser()) {
            $this->app->bind(
                UserFactoryInterface::class,
                static fn() => new EloquentUserFactory(config('auth.providers.users.model'))
            );
        }

        $this->app->bind(FriendsClient::class, VKClient::class);
    }
}
