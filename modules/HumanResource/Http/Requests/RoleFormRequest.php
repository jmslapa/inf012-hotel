<?php

namespace Modules\HumanResource\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Enums\PolicyMethod;
use Modules\Auth\Models\Permission;
use Modules\HumanResource\Models\Role;

class RoleFormRequest extends FormRequest
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

        $exists = function ($attr, $value, $fail) {
            if (is_array($value) && count($value) && !Permission::query()->whereIn('id', $value)->count()) {
                $fail("The $attr must have only valid permission IDs");
            }
        };

        switch (Route::currentRouteName()) {
            case 'api.hr.roles.store':
                return [
                    'name' => ['required', 'string', 'min:3'],
                    'permissions' => ['nullable', 'array', $exists]
                ];
            
            case 'api.hr.roles.update':
                return [
                    'name' => ['required', 'string', 'min:3'],
                    'enabled' => ['required', 'boolean'],
                    'permissions' => ['nullable', 'array', $exists]
                ];

            default:
                return [];
        }
    }
}
