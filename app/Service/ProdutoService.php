<?php

namespace App\Service;

use App\Models\Produto;
use App\Repositories\ProdutoRepositoriesInterface;

class ProdutoService
{

  private $repositories;
  private $model;
  public function __construct(ProdutoRepositoriesInterface $repositories, Produto $model)
  {
    $this->model = $model;
    $this->repositories = $repositories;
  }

  public function index()
  {
    return $this->repositories->index();
  }

  public function store($data)
  {
    $data->validate($this->model->regras(), $this->model->feedback());
    return $this->repositories->store($data);
  }

  public function show($id)
  {
    return $this->repositories->show($id);
  }

  public function update($data, $id)
  {
    $data->validate($this->model->regras(), $this->model->feedback());
    return $this->repositories->update($data, $id);
  }

  public function destroy($id)
  {
    return $this->repositories->destroy($id);
  }
}
