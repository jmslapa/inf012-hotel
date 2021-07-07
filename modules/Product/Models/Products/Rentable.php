<?php

namespace Modules\Product\Models\Products;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Common\Models\Image;
use Modules\Common\Traits\Imageable;
use Modules\Product\Abstracts\Products\Product;
use Modules\Product\Interfaces\Products\IRentable;
use Modules\Product\Models\Categories\RentableCategory;

class Rentable extends Product implements IRentable
{
    use Imageable;

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope('loadImages', fn(Builder $q) => $q->with('images'));
    }

    public function calcRentalValue(Carbon $start, Carbon $end): float
    {
        $days = ($start->floatDiffInDays($end));
        return (float) bcmul($days, ceil($this->unit_price), 2);
    }

    public function isRented(): bool
    {
        return false;
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): Relation
    {
        return $this->belongsToMany(RentableCategory::class, 'category_rentable', 'rentable_id', 'category_id');
    }

    /**
     * @return MorphMany
     */
    public function images(): Relation
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
