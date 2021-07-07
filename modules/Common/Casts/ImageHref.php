<?php

namespace Modules\Common\Casts;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ImageHref implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return url('storage/'.$value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return Str::after($value, 'storage/');
    }
}
