<?php

namespace Modules\Store\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Enums\PolicyMethod;
use Support\Interfaces\Services\IModelService;
use Modules\Store\Http\Requests\BookingFormRequest;
use Modules\Store\Models\Booking;

class BookingController extends Controller
{
    private $request;
    private $service;

    public function __construct(IModelService $service)
    {
        $this->service = $service;
        $this->request = app(BookingFormRequest::class);
    }

    public function index()
    {
        $this->authorize(PolicyMethod::VIEW_ANY, Booking::class);
        return response()->json($this->service->all(), 200);
    }

    public function show(int $id)
    {
        $booking = $this->service->find($id);
        $this->authorize(PolicyMethod::VIEW, $booking);
        return response()->json($this->service->find($id), 200);
    }

    public function store()
    {
        $this->authorize(PolicyMethod::CREATE, Booking::class);
        return response()->json($this->service->create($this->request->validated()), 201);
    }

    public function update(int $id)
    {
        $booking = $this->service->find($id);
        $this->authorize(PolicyMethod::UPDATE, $booking);
        return response()->json(
            $this->service->update(
                $booking,
                $this->request->validated()
            ),
            202
        );
    }

    public function destroy(int $id)
    {
        $this->authorize(PolicyMethod::DELETE, Booking::class);
        return response()->json(
            $this->service->delete(
                $this->service->find($id)
            ),
            204
        );
    }

    public function addDemandable(int $booking)
    {
        $booking = $this->service->find($booking);
        $this->authorize('addDemandable', $booking);
        return response()->json(
            $this->service->addDemandable(
                $booking,
                $this->request->validated()
            ),
            202
        );
    }

    public function removeDemandable(int $booking, int $demandable)
    {
        $booking = $this->service->find($booking);
        $this->authorize('removeDemandable', $booking);
        return response()->json(
            $this->service->removeDemandable(
                $booking,
                $demandable
            ),
            204
        );
    }

    public function checkIn(int $booking)
    {
        $booking = $this->service->find($booking);
        $this->authorize('checkIn', $booking);
        return response()->json(
            $this->service->checkIn(
                $booking
            ),
            200
        );
    }

    public function checkOut(int $booking)
    {
        $booking = $this->service->find($booking);
        $this->authorize('checkOut', $booking);
        return response()->json(
            $this->service->checkOut(
                $booking
            ),
            200
        );
    }
}
