<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultarCreditoController;


Route::get('/consultaCredito/{cpf}',[ConsultarCreditoController::class,'exibirCredito']);
