<?php

namespace Modules\Product\Abstracts\Categories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Interfaces\Categories\IProductCategory;

abstract class ProductCategory extends Model implements IProductCategory
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'enabled'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];
}
