<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

if (!class_exists(\Abedin\Maker\Repositories\Repository::class, false)) {
    spl_autoload_register(function ($class) {
        if ($class === 'Abedin\\Maker\\Repositories\\Repository') {
            $fallback = dirname(__DIR__) . '/app/Maker/Repositories/Repository.php';
            if (file_exists($fallback)) {
                require_once $fallback;
            }
        }
    });
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
