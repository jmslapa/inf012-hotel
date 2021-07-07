<?php

namespace Modules\Product\Interfaces\Services;

use Modules\Product\Interfaces\Products\IRentable;
use Support\Interfaces\Services\IEloquentModelService;
use Support\Interfaces\Services\IModelService;

interface IRentableService extends IEloquentModelService, IModelService
{
    /**
     * Realiza o upload de imagens de um Rentable.
     *
     * @param integer $id
     * @param UploadedFile[] $images
     * @return IRentable
     */
    public function uploadImages(IRentable $rentable, array $images): IRentable;

    /**
     * Realiza a exclusão de um grupo de imagens de um Rentable.
     *
     * @param integer $id
     * @param int[] $images IDs das imagens a serem removidas
     * @return IRentable
     */
    public function removeImages(IRentable $rentable, array $images): IRentable;
}
