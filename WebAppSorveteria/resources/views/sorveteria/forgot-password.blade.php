<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Senha</title>
</head>
<body>
    <h2>Recuperar Senha</h2>

    @if(session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif

    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <button type="submit">Enviar link de recuperação</button>
    </form>

    <p><a href="{{ route('login') }}">Voltar ao login</a></p>
</body>
</html>
