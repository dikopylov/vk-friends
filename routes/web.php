<?php

use App\Http\Controllers\API\FriendsController;
use App\Http\Controllers\API\MutualFriendsController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VKAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('vk/auth')
    ->group(
        static function () {
            Route::post('', [VKAuthController::class, 'auth'])->name('auth');
            Route::get('verify', [VKAuthController::class, 'verify']);
        }
    );

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

Route::prefix('api')
    ->middleware(['auth', 'token',])
    ->group(
        static function () {
            Route::prefix('tags')
                ->group(
                    static function () {
                        Route::get('', [TagController::class, 'index'])->name('tags.index');
                        Route::post('', [TagController::class, 'store'])->name('tags.create');
                    }
                );


            Route::prefix('friends')
                ->group(
                    static function () {
                        Route::get('', [FriendsController::class, 'index'])->name('friends');

                        Route::get('mutual/{id}', [MutualFriendsController::class, 'show'])->name('friends.mutual')
                            ->where('id', '[0-9]+');
                    }
                );
        }
    );

Route::middleware('auth')
    ->get('{any}', static fn() => view('home'))
    ->where('any', '.*');

