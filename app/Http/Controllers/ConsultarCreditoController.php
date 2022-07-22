<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Service\ConsultarCreditoService;
use Illuminate\Http\JsonResponse;

class ConsultarCreditoController extends Controller
{
    public function exibirCredito(Request $request): JsonResponse
    {
        $cpf = $request->cpf;
        if(!is_numeric($cpf) && strlen($cpf) != 11 ){
            return response()->json(['error' => 'Porfavor Insira Um Cpf Valido Com 11 Digitos, Não Pode Conter Letras']);
        }

        $consulta =  ConsultarCreditoService::consultarCredito($cpf);

        return response()->json($consulta);
    }

}
