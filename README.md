# QuickStart


### Requisitos: 

```
PHP 7.4.3
Composer version 2.3.7
```


### Instalar Dependencias 

```
composer install
```

### Rodar o Projeto:

```
php artisan serve

```
### Endpoint
#### GET - /api/consultaCredito/$cpf
#### CPF disponiveis : "11111111111","12312312312","22222222222" .

```
Exemplo: "http://localhost:8000/api/consultaCredito/11111111111
```
#### Exemplo de Resposta
```
[
    {
        "instituicaoFinanceira": "Financeira Assert",
        "modalidadeCredito": "crédito pessoal",
        "valorAPagar": 7122.64,
        "valorSolicitado": 7000,
        "qntParcelas": 48,
        "taxaJuros": 122.64
    },
    {
        "instituicaoFinanceira": "Banco PingApp",
        "modalidadeCredito": "crédito consignado",
        "valorAPagar": 19413.55,
        "valorSolicitado": 19250,
        "qntParcelas": 72,
        "taxaJuros": 163.55
    },
    {
        "instituicaoFinanceira": "Banco PingApp",
        "modalidadeCredito": "crédito pessoal",
        "valorAPagar": 8190.08,
        "valorSolicitado": 8000,
        "qntParcelas": 48,
        "taxaJuros": 190.08
    }
]
```
#### Exemplo De Error
```
{
    "error": "Porfavor Insira Um Cpf Valido Com 11 Digitos, Não Pode Conter Letras"
}
```
