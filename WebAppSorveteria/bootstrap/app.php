<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registra o middleware de rota 'firebase'
        $middleware->alias([
    'firebase' => \App\Http\Middleware\FirebaseAuth::class,
]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configurações de tratamento de exceções podem ficar aqui
    })
    ->create();
