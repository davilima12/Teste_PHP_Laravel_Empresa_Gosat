<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'fabricante',
        'validade',
        'estoqueAtual',
        'situacao'
    ];

    public function regras()
    {
        return [
            'nome' => 'required|min:3',
            'fabricante' => 'required|min:3',
            'estoqueAtual' => 'required|min:1|numeric',
            'situacao' => 'required|min:1'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O Campo :attribute É Obrigatorio',
            'min' => 'O Campo :attribute Não Pode Conter Poucos Digitos',
            'numeric' => 'O Campo :attribute Presisa Ser Um Número',

        ];
    }
}
