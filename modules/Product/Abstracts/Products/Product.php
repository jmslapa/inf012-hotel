<?php

namespace Modules\Product\Abstracts\Products;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Interfaces\Products\IProduct;

abstract class Product extends Model implements IProduct
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'unit_price',
        'measurement_unit',
        'enabled'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    protected static function booted()
    {
        static::addGlobalScope('loadCategories', fn(Builder $q) => $q->with('categories'));
    }
}
