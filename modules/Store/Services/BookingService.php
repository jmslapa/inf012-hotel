<?php

namespace Modules\Store\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Store\Services\Payloads\BookingFiltersPayload;
use Support\Abstracts\Services\EloquentModelService;
use Support\Interfaces\Services\Payloads\IEloquentFiltersPayload;

class BookingService extends EloquentModelService
{
    private $filters;

    public function getFilters(): IEloquentFiltersPayload
    {
        if (!($this->filters instanceof IEloquentFiltersPayload)) {
            $this->filters = BookingFiltersPayload::makeFromRequest(request());
        }

        return $this->filters;
    }

    public function create(array $data): object
    {
        $booking = parent::create($data);
        if (isset($data['demandables'])) {
            $booking->demandables()->createMany($data['demandables']);
        }
        return $this->find($booking->id);
    }

    public function delete(object $model): void
    {
        if ($model->demandables()->count()) {
            $model->demandables()->delete();
        }
        parent::delete($model);
    }

    public function addDemandable(Model $booking, array $data)
    {
        $booking->demandables()->create($data);
        return $this->find($booking->id);
    }

    public function removeDemandable(Model $booking, int $demandableId)
    {
        $booking->demandables()->where('id', $demandableId)->delete();
        return $this->find($booking->id);
    }

    public function checkIn(Model $booking)
    {
        if ($booking->lodging !== null) {
            abort(400, 'There is an active previous check-in.');
        }
        $booking->lodging()->create();
        return $this->find($booking->id);
    }

    public function checkOut(Model $booking)
    {
        $lodging = $booking->lodging;
        if ($lodging === null) {
            abort(400, 'There is no active lodging');
        }
        if (!$lodging->isActive()) {
            abort(400, 'The lodging is already finished.');
        }
        $lodging->check_out = now();
        $lodging->save();
        return $this->find($booking->id);
    }
}
