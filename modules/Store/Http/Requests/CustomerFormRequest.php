<?php

namespace Modules\Store\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Http\Requests\UserFormRequest;
use Modules\Common\Traits\HasAddress;
use Modules\Common\Traits\HasPhone;

class CustomerFormRequest extends UserFormRequest
{
    use HasAddress, HasPhone;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
     
        if (!request()->route()) {
            return [];
        }

        $common = array_merge([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'nationality' => ['required', 'string', 'min:3', 'max:40'],
            'birth' => ['required', 'date_format:d/m/Y', 'before:18 years ago'],
            'cpf' => ['required', 'digits:11'],
            'enabled' => ['nullable', 'boolean'],
        ], $this->getAddressRules());

        switch (request()->route()->getName()) {
            case 'api.store.customer.store':
                return array_merge(
                    array_merge(parent::rules(), $common),
                    $this->getMultiPhoneRules()
                );
            
            case 'api.store.customer.update':
                return $common;
            
            case 'api.store.customer.add-phone':
                return [
                    'number' => ['required', 'digits:14']
                ];

            default:
                return [];
        }
    }
}
