<?php

namespace App\Http\Controllers;

use App\Service\ProdutoService;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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


        try {
            if ($this->service->destroy($id) != null) {
                return response()->json(['result' => 'Registro Deletado Com Sucesso']);
            }
            return response()->json(['error' => 'Não Enxiste Um Registro Com Esse Id'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
