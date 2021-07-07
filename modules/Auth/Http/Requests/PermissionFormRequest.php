<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Http\Requests\UserFormRequest;
use Modules\Auth\Models\Permission;

class PermissionFormRequest extends UserFormRequest
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
            case 'api.hr.employees.store':
                return array_merge(parent::rules(), [
                    'name' => ['required', 'string', 'min:3'],
                    'cpf' => ['required', 'digits:11'],
                    'gender' => ['required', 'in:F,M'],
                    'role_id' => ['required', 'exists:roles,id,deleted_at,NULL']
                ]);
            
            case 'api.hr.employees.update':
                return [
                    'name' => ['required', 'string', 'min:3'],
                    'gender' => ['required', 'in:F,M'],
                    'role_id' => ['required', 'exists:roles,id,deleted_at,NULL'],
                    'enabled' => ['required', 'boolean']
                ];

            default:
                return [];
        }
    }
}
