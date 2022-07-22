<?php

namespace App\Service;

class JurosCalculatorService 
{ 
  public function calcularTotalDeJuros(int $valorTotal, float $porcetagemDeJuros, int $parcelas): float
  {
    $jurosMensalEmReais = self::calcularJurosMensalEmReais($valorTotal,$porcetagemDeJuros);
    return self::calcularJurosTotalEmReais($jurosMensalEmReais,$parcelas);
  }

  public function calcularValorTotalComJuros(int $valorTotal, float $juros): float
  {
    return $valorTotal + $juros;
  }

  public function calcularJurosMensalEmReais(int $valorTotal, float $porcetagemDeJuros): float
  {
   return ($valorTotal / 100) * $porcetagemDeJuros;
  }

  public function calcularJurosTotalEmReais(float $jurosMensais, int $parcelas): float
  {
    $totalDeJuros = $jurosMensais * $parcelas;
    
    return floatval(number_format($totalDeJuros, 2, '.', ''));
  }

}
