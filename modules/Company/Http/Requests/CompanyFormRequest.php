<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Common\Traits\HasAddress;
use Modules\Common\Traits\HasPhone;

class CompanyFormRequest extends FormRequest
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
        
        $id = request()->route('company');
        $routeName = request()->route()->getName();
        $rules = array_merge(
            $this->getAddressRules(),
            $this->getMultiPhoneRules()
        );
        
        switch ($routeName) {
            case 'api.company.store':
                return array_merge([
                    'name' => ['required', 'string', 'min:3', 'max:100'],
                    'category' => ['required', 'string', 'min:3', 'max:60'],
                    'email' => ['required', 'email', 'max:60', 'unique:companies,email'],
                    'address' => ['required'],
                ], $rules);  
            case 'api.company.update':
                return array_merge([
                    'name' => ['required', 'string', 'min:3', 'max:100'],
                    'category' => ['required', 'string', 'min:3', 'max:60'],
                    'email' => ['required', 'email', 'max:60', "unique:companies,email,$id,id"],
                    'address' => ['required'],
                ], $rules);

            case 'api.company.add-phone':
                return [
                    'number' => ['required', 'digits:14']
                ];
            default:
                return [];
        }
    }
}
