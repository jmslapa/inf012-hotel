<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryFormRequest extends FormRequest
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

        $id = request()->route('category');
        switch (request()->route()->getName()) {
            case 'api.product.rentable-category.store':
            case 'api.product.rentable-category.update':
            case 'api.product.demandable-category.store':
            case 'api.product.demandable-category.update':
                return [
                    'name' => ['required', 'string', 'min:3', 'max:60', "unique:rentable_categories,name,{$id},id"],
                    'enabled' => ['nullable', 'boolean']
                ];

            default:
                return [];
        }
    }
}
