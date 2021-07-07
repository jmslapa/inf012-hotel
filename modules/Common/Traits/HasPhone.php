<?php

namespace Modules\Common\Traits;

trait HasPhone
{

    public function getPhoneRules()
    {
        return [
            'phone.number' => ['required', 'digits:14'],
            'phone.enable' => ['nullable', 'boolean'],
        ];
    }

    public function getMultiPhoneRules()
    {
        return [
            'phones' => ['required', 'array', 'min:1'],
            'phones.*.number' => ['required', 'digits:14'],
            'phones.*.enable' => ['nullable', 'boolean'],
        ];
    }
}
