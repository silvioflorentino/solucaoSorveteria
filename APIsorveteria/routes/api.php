<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SorveteController;


//rotas para visualizar os registros
Route::get('/',function(){return response()->json(['Sucesso'=>true]);});
Route::get('/sorvete',[SorveteController::class,'index']);
Route::get('/sorvete/{codigo}',[SorveteController::class,'show']);

//rota para inserir os registros
Route::post('/sorvete',[SorveteController::class,'store']);

//rota para alterar os registros
Route::put('/sorvete/{codigo}',[SorveteController::class,'update']);

//rota para excluir o registro por id/codigo
Route::delete('/sorvete/{id}',[SorveteController::class,'destroy']);


