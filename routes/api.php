<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoints de autenticação
//Endpoint de registro
Route::post('/register-user', [AuthController::class, 'registerUser']);

//Endpoint de login
Route::post('/login', [AuthController::class, 'login']);

//Endpoint de registrar um produto
Route::post('/register-product', [ProductController::class, 'registerProduct']);

//Endpoint de retornar o usuario
Route::get('/return-products' , [ProductController::class, 'index']);

//Endpoint de retornar todos os usuários
Route::get('/return-users', [AuthController::class, 'returnUser']);

Route::put('/update-product/{id}', [ProductController::class,'update']);

Route::delete('/delete-product/{id}', [ProductController::class,'delete']);