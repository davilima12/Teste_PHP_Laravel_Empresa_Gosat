<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultarCreditoController;
use App\Http\Controllers\ProdutoController;

Route::get('/consultaCredito/{cpf?}', [ConsultarCreditoController::class, 'exibirCredito']);
Route::apiResource('produtos', ProdutoController::class);
