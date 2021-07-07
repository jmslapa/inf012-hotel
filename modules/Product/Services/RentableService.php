<?php

namespace Modules\Product\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\Product\Abstracts\Services\ProductService;
use Modules\Product\Interfaces\Products\IRentable;
use Modules\Product\Interfaces\Services\IRentableService;
use Modules\Product\Interfaces\Services\Payloads\IProductFiltersPayload;
use Modules\Product\Services\Payloads\ProductFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class RentableService extends ProductService implements IRentableService
{
    /**
     * Realiza o upload de imagens de um Rentable.
     *
     * @param integer $id
     * @param UploadedFile[] $images
     * @return IRentable
     */
    public function uploadImages(IRentable $rentable, array $images): IRentable
    {
        $max = config('products.rentable.max_images');
        $imageCount = $rentable->images()->count();
        $limit = $max - $imageCount;
        if (count($images) <= $limit) {
            $rentable->saveImages($images);
        } else {
            abort(422, "The max number of images a Rentable can have is $max.");
        }
        return $rentable->load('images');
    }

    /**
     * Realiza a exclusão de um grupo de imagens de um Rentable.
     *
     * @param integer $id
     * @param int[] $images IDs das imagens a serem removidas
     * @return IRentable
     */
    public function removeImages(IRentable $rentable, array $images): IRentable
    {
        $rentable->removeImages($images);
        return $rentable->load('images');
    }
}
