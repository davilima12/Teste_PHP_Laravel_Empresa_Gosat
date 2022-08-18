<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ProdutoRepositories implements produtoRepositoriesInterface
{

  private $model;

  public function __construct(Model $model)
  {
    return $this->model = $model;
  }

  public function index($data, $params = null, $filtros = null)
  {

    if ($filtros != null) {
      foreach ($filtros as $condicao) {
        $filtro = explode(':', $condicao);
        $this->model =  $this->model->where($filtro[0], $filtro[1], $filtro[2]);
      }
    }
    if ($params != null) {
      return  $this->model->selectRaw($params)->get();
    }

    return $this->model->get();
  }

  public function store($data)
  {
    return $this->model->create($data->all());
  }

  public function show($id)
  {
    return $this->model->find($id);
  }

  public function update($data, $id)
  {
    return $this->model->find($id)->update($data->all());
  }

  public function destroy($id)
  {
    return $this->model->find($id)->delete();
  }
}
