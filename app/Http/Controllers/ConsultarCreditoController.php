<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Service\ConsultarCreditoService;

class ConsultarCreditoController extends Controller
{
    public function exibirCredito( Request $request){
        $cpf = $request->cpf;
        if(is_numeric($cpf) && strlen($cpf) == 11 ){
            $consulta =  ConsultarCreditoService::consultarCredito($cpf);
            return json_encode($consulta, JSON_UNESCAPED_UNICODE);
        }
        return 'Porfavor Insira Um Cpf Valido Com 11 Digitos, Não Pode Conter Letras';

    }

}
