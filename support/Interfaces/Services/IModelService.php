<?php

namespace Support\Interfaces\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface IModelService
{
    /**
     * Retorna uma coleção ou paginação de models
     *
     * @return Collection|LengthAwarePaginator
     */
    public function all();

    /**
     * Busca um model por id e o retorna, caso exista. Caso não encontre o model, lança uma exceção.
     *
     * @param integer $id
     * @return object
     * @throws NotFoundHttpException
     */
    public function find(int $id): object;

    /**
     * Recebe um array associativo e tenta persistir um model no banco de dados a partir dos dados contidos no mesmo.
     *
     * @param array $data
     * @return object
     */
    public function create(array $data): object;

    /**
     * Atualiza um model baseado nos dados contidos no array associativo e retorna o próprio, porém já atualizado.
     *
     * @param object $model
     * @param array $data
     * @return object
     */
    public function update(object $model, array $data): object;

    /**
     * Executa uma exclusão de um model do banco de dados.
     *
     * @param object $model
     * @return void
     */
    public function delete(object $model): void;
}
