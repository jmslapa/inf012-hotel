<?php

namespace Modules\Store\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Modules\Product\Models\Products\Demandable;

class BookingFormRequest extends FormRequest
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

        $demandableExists = function ($attr, $value, $fail) {
            $ids = collect($value)->pluck('demandable_id');
            if (is_array($value)
                && count($value)
                && !Demandable::query()
                    ->whereIn('id', $ids)
                    ->whereNull('deleted_at')
                    ->count()
            ) {
                $fail("The $attr must have only valid demandables IDs");
            }
        };

        $common = [
            'customer_id' => ['required', 'exists:customers,id,deleted_at,NULL'],
            'rentable_id' => [['required', 'exists:rentables,id,deleted_at,NULL']],
            'start' => ['required', 'date_format:d/m/Y', 'after_or_equal:today'],
            'end' => ['required', 'date_format:d/m/Y', 'after:start'],
            'status' => ['nullable', 'in:PENDING,FINISHED,CANCELLED'],
        ];

        switch (Route::currentRouteName()) {
            case 'api.store.booking.store':
                return array_merge($common, [
                    'demandables' => ['nullable', 'array', 'min:1', $demandableExists],
                    'demandables.*.demandable_id' => ['required'],
                    'demandables.*.amount' => ['required', 'integer', 'min:1']
                ]);
            
            case 'api.store.booking.update':
                return Arr::only($common, ['rentable_id', 'start', 'end']);

            case 'api.store.booking.add-demandable':
                return [
                    'demandable_id' => ['required', 'exists:demandables,id,deleted_at,NULL'],
                    'amount' => ['required', 'integer', 'min:1']
                ];

            default:
                return [];
        }
    }
}
