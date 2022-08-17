<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepositories
{

  private $model;

  public function __construct(Produto $model)
  {
    return $this->model = $model;
  }

  public function index()
  {
    return response()->json($this->model->all());
  }

  public function store($data)
  {
    return $this->model->create($data->all());
  }

  public function show($id)
  {
    return response()->json($this->model->find($id));
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
