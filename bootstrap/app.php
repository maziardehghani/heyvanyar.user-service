<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function() {

            Route::middleware(['api', 'auth:sanctum'])
            ->namespace('users')
            ->prefix('panel/users')
            ->name('users.panel')
            ->group(base_path('routes/panel.php'));

            Route::middleware('api')
            ->namespace('auth')
            ->prefix('account')
            ->name('account')
            ->group(base_path('routes/auth.php'));


            Route::middleware('api')
            ->namespace('users')
            ->prefix('users')
            ->name('users')
            ->group(base_path('routes/site.php'));



        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
