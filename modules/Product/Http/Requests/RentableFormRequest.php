<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Common\Traits\ValidateImageUpload;
use Modules\Product\Models\Categories\RentableCategory;

class RentableFormRequest extends FormRequest
{
    use ValidateImageUpload;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!request()->route()) {
            return [];
        }

        $categoryExists = function ($attr, $value, $fail) {
            if (is_array($value) && count($value) && !RentableCategory::query()->whereIn('id', $value)->count()) {
                $fail("The $attr must have only valid category IDs");
            }
        };

        $common = [
            'title' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:3', 'max:500'],
            'unit_price' => ['required', 'numeric', 'min:0.00', 'max:99999999.99'],
            'measurement_unit' => ['nullable', 'string', 'min:3', 'max:30'],
            'enabled' => ['nullable', 'boolean'],
            'categories' => ['required', 'array', 'min:1', $categoryExists]
        ];

        switch (request()->route()->getName()) {
            case 'api.product.rentable.store':
                return $common;
            
            case 'api.product.rentable.update':
                return $common;

            case 'api.product.rentable.upload-images':
                return [
                    'images' => $this->getImageArrayRules(config('products.rentable.max_images')),
                    'images.*'  => $this->getSingleImageRules()
                ];
            
            case 'api.product.rentable.remove-images':
                return [
                    'images' => ['required', 'array', 'min:1', app('image_exists')]
                ];

            default:
                return [];
        }
    }
}
