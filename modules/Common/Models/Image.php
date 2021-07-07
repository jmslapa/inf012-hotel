<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Common\Casts\ImageHref;

class Image extends Model
{
    protected $fillable = ['path'];

    protected $hidden = [
        'path',
        'imageable_type',
        'imageable_id'
    ];

    protected static function booted()
    {
        parent::booted();
        static::retrieved(function (Model $model) {
            $model->setAttribute('href', $model->path);
            return $model;
        });
    }

    protected $casts = [
        'href' => ImageHref::class
    ];

    public function imageable()
    {
        return $this->morphTo('imageable');
    }
}
