<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ProdutoRepositoriesInterface
{
  public function __construct(Model $model);
  public function index();
  public function store($data);
  public function show($id);
  public function update($data, $id);
  public function destroy($id);
}
