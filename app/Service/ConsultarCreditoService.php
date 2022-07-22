<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\RequestHandler\DevGosatRequestHandler;
use App\Service\JurosCalculatorService;

class ConsultarCreditoService
{
    public static function consultarCredito(string $cpf): array 
    {
        $instituicoeDoCLiente = DevGosatRequestHandler::consultaInstituicoesPorCpf($cpf);
        $instituicoes = self::getDadosinstituicoesFinanceirasDoCliente($instituicoeDoCLiente,$cpf);
        $dadosDasOfertasCredito = self::ofertaDeCreditoDoCliente($instituicoes);
        $ofertasCreditos = self::calcularValorApagarOfertaCredito($dadosDasOfertasCredito);
        $ofertaCreditoOrdenada = self::ordenarOfertaCreditoMaisVantajosa($ofertasCreditos);

        return $ofertaCreditoOrdenada;
    }

    public static function getDadosinstituicoesFinanceirasDoCliente(object $array, string $cpf) : array
    {
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

    public static function ofertaDeCreditoDoCliente(array $dados): array
    {
        $ofertasDoCliente = [];

        foreach($dados as $index => $ofertaCredito){
            $ofertasDoCliente = [
                ...$ofertasDoCliente,
                ...self::pegarModalidadesDeOfertaDeCredito($ofertaCredito)
            ];
        } 

        return $ofertasDoCliente; 
    }

    public static function pegarModalidadesDeOfertaDeCredito(array $ofertaCredito): array
    {
        $ofertasDoCliente = [];

        foreach ($ofertaCredito['modalidades'] as $modalidade){
            $ofertasDoCliente[] = [
                'instituicaoFinanceira' => $ofertaCredito['NomeDaInstituicao'],
                'modalidadeCredito' => $modalidade->nome,
                'ofertaDeCredito' => DevGosatRequestHandler::getSimulacaoOferta($ofertaCredito,$modalidade)
            ]; 
        }

        return $ofertasDoCliente;
    }

    public static function calcularValorApagarOfertaCredito(array $array): array
    {
        $ofertasCreditoPessoal = [];

        foreach($array as $dadosDoCredito){
            $valorMax = $dadosDoCredito['ofertaDeCredito']->valorMax;
            $jurosMes = $dadosDoCredito['ofertaDeCredito']->jurosMes;
            $parcelasMax = $dadosDoCredito['ofertaDeCredito']->QntParcelaMax;
            $taxaJuros = JurosCalculatorService::calcularTotalDeJuros(
                $valorMax,
                $jurosMes,
                $parcelasMax
            );
            $valorAPagar = JurosCalculatorService::calcularValorTotalComJuros($valorMax,$taxaJuros);
            $ofertasCreditoPessoal[] = [
                'instituicaoFinanceira' => $dadosDoCredito['instituicaoFinanceira'],
                'modalidadeCredito' => $dadosDoCredito['modalidadeCredito'],
                'valorAPagar' => $valorAPagar,
                'valorSolicitado' => $valorMax,
                'qntParcelas' => $parcelasMax,
                'taxaJuros' => $taxaJuros,
            ];
        }

        return $ofertasCreditoPessoal;
    }

    public static function ordenarOfertaCreditoMaisVantajosa(array $array): array
    {
        $marks = array();
        foreach ($array as $key => $row)
        {
            $marks[$key] = $row['taxaJuros'];
        }
        array_multisort($marks, SORT_ASC, $array);

       return $array;
    }
}
