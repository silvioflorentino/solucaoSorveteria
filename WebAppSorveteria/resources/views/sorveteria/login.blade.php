<!DOCTYPE html>
<html>
<head>
    <title>Login Firebase</title>
</head>
<body>
    <h2>Login</h2>
    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif
    <form method="POST" action="/login">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Senha:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="{{ route('register.form') }}">Cadastre-se aqui</a></p>

</body>
</html>