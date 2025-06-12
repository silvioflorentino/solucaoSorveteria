<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sorvete;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class SorveteController extends Controller
{
    //Mostrar todos os registros

    public function index()
    {
        //Buscando os sabores do sorvetes
       
        $registros = Sorvete::all();

        $contador = $registros->count();

        if ($contador > 0) {
            return Response()->json([
                'sucesso'=> true,
                'mensagem' => 'Sorvetes localizados',
                'data' => $registros,
                'total' => $contador
            ],200);
        }else{
            return Response()->json([
                'sucesso'=>false,
                'mensagem'=>'Erro ao achar os sorvetes'
            ],404);
        }
    }
 /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validação dos dados recebidos
    $validator = Validator::make($request->all(), [
        'sabor' => 'required',
        'descricao' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400); // Retorna HTTP 400 (Bad Request) se houver erro de validação
    }

    // Criando um sabor no banco de dados
    $registros = Sorvete::create($request->all());

    if ($registros) {
        return response()->json([
            'success' => true,
            'message' => 'Sabor cadastrada com sucesso!',
            'data' => $registros
        ], 201); 
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao cadastrar um sabor'
        ], 500); // Retorna HTTP 500 (Internal Server Error) se o cadastro falhar
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscando um sabor pelo ID
        $registros = Sorvete::find($id);
    
        // Verificando se a sabor foi encontrada
        if ($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Sabor localizada com sucesso!',
                'data' => $registros
            ], 200); // Retorna HTTP 200 (OK) com os dados do sabor
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sabor não localizada.',
            ], 404); // Retorna HTTP 404 (Not Found) se um sabor não for encontrada
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [
        'sabor' => 'required',
        'descricao' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Registros inválidos',
            'errors' => $validator->errors()
        ], 400); // Retorna HTTP 400 se houver erro de validação
    }

    // Encontrando a criptomoeda no banco
    $registrosBanco = Sorvete::find($id);

    if (!$registrosBanco) {
        return response()->json([
            'success' => false,
            'message' => 'Sabor não encontrado'
        ], 404); 
    }

    // Atualizando os dados
    $registrosBanco->sabor = $request->sabor;
    $registrosBanco->descricao = $request->descricao;


    // Salvando as alterações
    if ($registrosBanco->save()) {
        return response()->json([
            'success' => true,
            'message' => 'Sabor atualizado com sucesso!',
            'data' => $registrosBanco
        ], 200); // Retorna HTTP 200 se a atualização for bem-sucedida
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao atualizar os sabores'
        ], 500); // Retorna HTTP 500 se houver erro ao salvar
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Encontrando um sabor no banco
    $registros = Sorvete::find($id);

    if (!$registros) {
        return response()->json([
            'success' => false,
            'message' => 'sabor não encontrado'
        ], 404); // Retorna HTTP 404 se o sabor não for encontrado
    }

    // Deletando um sabor
    if ($registros->delete()) {
        return response()->json([
            'success' => true,
            'message' => 'Sabor deletado com sucesso'
        ], 200); // Retorna HTTP 200 se a exclusão for bem-sucedida
    }

    return response()->json([
        'success' => false,
        'message' => 'Erro ao deletar um sabor'
    ], 500); // Retorna HTTP 500 se houver erro na exclusão
}
}


