<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas de autenticação
//rota de registro
Route::post('/register-user', [AuthController::class, 'registerProduct']);

//rota de login
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register-product', [ProductController::class, 'registerProduct']);


