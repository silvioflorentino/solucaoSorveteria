Para colocar o firebase na web

1 - criar a controller
AuthController
2- chave do firebase no .env

3- Criar uma pasta em Http 

Middleware
Arquivo->FirebaseAuth.php

4-Bootstrap
dentro do app.php colocar:
        $middleware->alias([
    'firebase' => \App\Http\Middleware\FirebaseAuth::class,

Não esquecer da Rota
