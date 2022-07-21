<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Service\ConsultarCreditoService;

class ConsultarCreditoController extends Controller
{
    public function exibirCredito( Request $request){
        $cpf = $request->cpf;
        $consulta =  ConsultarCreditoService::consultarCredito($cpf);
        dd($consulta);
    }

}
