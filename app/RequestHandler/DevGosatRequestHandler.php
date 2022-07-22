<?php

namespace App\RequestHandler;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DevGosatRequestHandler 
{
  private const BASE_DEV_GOSAT_URL = 'https://dev.gosat.org/api/v1';

  public static function consultaInstituicoesPorCpf(string $cpf): object
  {
    $resposta =  Http::post(self::BASE_DEV_GOSAT_URL . '/simulacao/credito',[
        'cpf' => $cpf,
    ]);

   return json_decode($resposta);
  }

  public static function getSimulacaoOferta(array $ofertaCredito, object $modalidade): object
  {
    $responseJson = Http::post(self::BASE_DEV_GOSAT_URL . '/simulacao/oferta',[
      'cpf' => $ofertaCredito['cpfCLiente'],
      'instituicao_id' => $ofertaCredito['id'],
      'codModalidade' => $modalidade->cod
    ]);

    return json_decode($responseJson);
  }
}
