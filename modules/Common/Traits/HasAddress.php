<?php

namespace Modules\Common\Traits;

trait HasAddress
{

    public function getAddressRules()
    {
        return [
            'address.zip' => ['required', 'digits:8'],
            'address.number' => ['required', 'digits_between:1,8'],
            'address.address' => ['required', 'string', 'min:3', 'max:255'],
            'address.complement' => ['required', 'string', 'max:30'],
            'address.district' => ['required', 'string', 'min:3', 'max:30'],
            'address.city' => ['required', 'string', 'min:3', 'max:30'],
            'address.state' => ['required', 'string', 'min:2', 'max:2'],
            'address.enable' => ['nullable', 'boolean'],
        ];
    }
}
