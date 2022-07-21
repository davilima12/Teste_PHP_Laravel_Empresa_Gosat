<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsultarCreditoService
{
    public function consultarCredito($cpf){
        $resposta =  Http::post('https://dev.gosat.org/api/v1/simulacao/credito',[
            'cpf'=>$cpf,
        ]);
        $resposta = json_decode($resposta);
        $instituicoes = self::instituicoesFinanceiras($resposta,$cpf);
        $dadosDasOfertasCredito = self::ofertaDeCreditoDoCliente($instituicoes);
        $ofertasCreditos = self::calcularValorApagarOfertaCredito($dadosDasOfertasCredito);
        $ofertaCreditoOrdenada = self::ordenarOfertaCreditoMaisVantajosa($ofertasCreditos);

        return $ofertaCreditoOrdenada ;
    }

    public function instituicoesFinanceiras($array,$cpf){
        $instituicoesFinanceiras = [];
        foreach($array->instituicoes as $instituicao){
            $instituicoesFinanceiras[] = [
                'id' => $instituicao->id,
                'cpfCLiente' => $cpf,
                'NomeDaInstituicao' => $instituicao->nome,
                'modalidades' => $instituicao->modalidades
            ] ;
       }
       
        return ($instituicoesFinanceiras);
    }

    public function ofertaDeCreditoDoCliente($dados){
        $ofertasDoCliente = [];
        foreach($dados as $index => $ofertaCredito){
            if(isset( $ofertaCredito['modalidades'][1])){
                $ofertasDoCliente[] = [
                    'instituicaoFinanceira' => $ofertaCredito['NomeDaInstituicao'],
                    'modalidadeCredito' => $ofertaCredito['modalidades'][0]->nome,
                    'ofertaDeCredito' => json_decode( Http::post('https://dev.gosat.org/api/v1/simulacao/oferta',[
                    'cpf' => $ofertaCredito['cpfCLiente'],
                    'instituicao_id' => $ofertaCredito['id'],
                    'codModalidade' => $ofertaCredito['modalidades'][1]->cod
                ]))]; 
            }
            $ofertasDoCliente[] = [
                'instituicaoFinanceira' => $ofertaCredito['NomeDaInstituicao'],
                'modalidadeCredito' => $ofertaCredito['modalidades'][0]->nome,
                'ofertaDeCredito' => json_decode( Http::post('https://dev.gosat.org/api/v1/simulacao/oferta',[
                'cpf' => $ofertaCredito['cpfCLiente'],
                'instituicao_id' => $ofertaCredito['id'],
                'codModalidade' => $ofertaCredito['modalidades'][0]->cod
            ]))];
        }

        return $ofertasDoCliente;
        
    }

    public function calcularValorApagarOfertaCredito($array){
        $valorApagar = '';
        $ofertasCreditoPessoal = [];
        $taxaJuros = 0;
        foreach($array as $dadosDoCredito){
            $taxaJuros = $dadosDoCredito['ofertaDeCredito']->jurosMes *  $dadosDoCredito['ofertaDeCredito']-> QntParcelaMax;
            $valorAPagar = $dadosDoCredito['ofertaDeCredito']->valorMax + ($dadosDoCredito['ofertaDeCredito']->valorMax / 100 * $taxaJuros);
            $ofertasCreditoPessoal[] = [
                'instituicaoFinanceira' => $dadosDoCredito['instituicaoFinanceira'],
                'modalidadeCredito' => $dadosDoCredito['modalidadeCredito'],
                'valorAPagar' => $valorAPagar,
                'valorSolicitado' => $dadosDoCredito['ofertaDeCredito']->valorMax,
                'qntParcelas' => $dadosDoCredito['ofertaDeCredito']->QntParcelaMax,
                'taxaJuros' => $taxaJuros,
            ];
        }

        return $ofertasCreditoPessoal;
    }

    public function ordenarOfertaCreditoMaisVantajosa($array){
        $marks = array();
        foreach ($array as $key => $row)
        {
            $marks[$key] = $row['taxaJuros'];
        }
        array_multisort($marks, SORT_ASC, $array);

       return $array;
    }
}
