<?php

namespace App\Http\Controllers;

use App\Service\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    private $service;
    public function __construct(ProdutoService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json($this->service->index($request));
    }

    public function store(Request $request)
    {
        $this->service->store($request);
        return response()->json(['result' => 'Registro Cadastrado Com Sucesso']);
    }

    public function show($id)
    {
        return response()->json($this->service->show($id));
    }

    public function update(Request $request, $id)
    {
        $this->service->update($request, $id);
        return response()->json(['result' => 'Registro Editado Com Sucesso']);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(['result' => 'Registro Deletado Com Sucesso']);
    }
}
