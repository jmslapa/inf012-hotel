<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Product\Models\Categories\DemandableCategory;

class DemandableFormRequest extends FormRequest
{
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
            if (is_array($value) && count($value) && !DemandableCategory::query()->whereIn('id', $value)->count()) {
                $fail("The $attr must have only valid category IDs");
            }
        };

        switch (request()->route()->getName()) {
            case 'api.product.demandable.store':
            case 'api.product.demandable.update':
                return [
                    'title' => ['required', 'string', 'min:3', 'max:100'],
                    'description' => ['required', 'string', 'min:3', 'max:500'],
                    'unit_price' => ['required', 'numeric', 'min:0.00', 'max:99999999.99'],
                    'measurement_unit' => ['nullable', 'string', 'min:3', 'max:30'],
                    'enabled' => ['nullable', 'boolean'],
                    'categories' => ['required', 'array', 'min:1', $categoryExists]
                ];

            default:
                return [];
        }
    }
}
