<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas de autenticação
//rota de registro
Route::post('/register-user', [AuthController::class, 'register']);

//rota de login
Route::post('/login', [AuthController::class, 'login']);


