<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthFormRequest extends FormRequest
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
        
        switch (request()->route()->getName()) {
            case 'api.auth.login':
                return [
                    'email' => ['required', 'email'],
                    'password' => ['required', 'string','min:8']
                ];
            
            default:
                return [];
        }
    }
}
