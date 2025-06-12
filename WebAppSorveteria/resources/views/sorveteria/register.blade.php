<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label>
        <input type="password" name="password" required><br><br>

        <label>Confirmar Senha:</label>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem uma conta? <a href="{{ route('login') }}">Fazer login</a></p>
</body>
</html>