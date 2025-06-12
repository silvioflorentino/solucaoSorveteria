<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SorveteriaWebController extends Controller
{
    //Crud consumindo a API
    private $urlApi = 'https://apisorvete.webapptech.site/api/sorvete';

    public function index()
    {
        $response = Http::get($this->urlApi);
        $data = $response->json();
        return view('sorveteria.index', ['sorvetes' => $data['data'] ?? [], 'message' => $data['message'] ?? '']);
    }

    public function create()
    {
        return view('sorveteria.cadastrar');
    }

    public function store(Request $request)
    {
        Http::post($this->urlApi, $request->only('sabor', 'descricao'));
        return redirect()->route('sorveteria.index');
    }

    public function edit($id)
    {
        $response = Http::get("$this->urlApi/$id");
        $sorvetes = $response->json()['data'] ?? null;
        return view('sorveteria.editar', compact('sorvetes'));
    }

    public function update(Request $request, $id)
    {
        Http::put("$this->urlApi/$id", $request->only('sabor', 'descricao'));
        return redirect()->route('sorveteria.index');
    }

    public function destroy($id)
    {
        Http::delete("$this->urlApi/$id");
        return redirect()->route('sorveteria.index');
    }
}
