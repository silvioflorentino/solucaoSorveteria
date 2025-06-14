<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('sorveteria.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $apiKey = env('FIREBASE_API_KEY');

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key={$apiKey}", [
            'email' => $request->email,
            'password' => $request->password,
            'returnSecureToken' => true
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('firebase_user', [
                'idToken' => $data['idToken'],
                'email' => $data['email'],
                'uid' => $data['localId'],
            ]);
            return redirect('/home');
        }

        return redirect()->back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    public function home()
    {
        return view('sorveteria.index');
    }

    public function logout()
    {
        Session::forget('firebase_user');
        return redirect('/login');
    }
    public function showRegisterForm()
    {
        return view('sorveteria.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $apiKey = env('FIREBASE_API_KEY');

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:signUp?key={$apiKey}", [
            'email' => $request->email,
            'password' => $request->password,
            'returnSecureToken' => true
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('firebase_user', [
                'idToken' => $data['idToken'],
                'email' => $data['email'],
                'uid' => $data['localId'],
            ]);
            return redirect('/home');
        }

        return redirect()->back()->withErrors(['email' => 'Erro ao cadastrar. Talvez o e-mail já esteja em uso.']);
    }
    public function showForgotPasswordForm()
    {
        return view('sorveteria.forgot-password');
    }
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $apiKey = env('FIREBASE_API_KEY');

        $response = Http::post("https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode?key={$apiKey}", [
            'requestType' => 'PASSWORD_RESET',
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return back()->with('status', 'Link de redefinição enviado para o seu email.');
        }

        $error = $response->json('error.message') ?? 'Erro ao enviar o link.';

        return back()->withErrors(['email' => $error]);
    }
}
