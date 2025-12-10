<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // PERBAIKAN: Paksa render JSON jika error Authentication terjadi di API
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            // Cek jika request mengarah ke 'api/*' ATAU client minta JSON
            if ($request->is('api/*')) {
                return true;
            }
            return $request->expectsJson();
        });
    })->create();