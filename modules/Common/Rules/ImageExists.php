<?php

namespace Modules\Common\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Common\Models\Image;

class ImageExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_array($value) && count($value) && Image::query()->whereIn('id', $value)->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute field must have only valid image IDs';
    }
}
