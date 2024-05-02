<?php

namespace App\Services\Buyer;

use App\Http\Requests\Buyer\StoreBookingRequest;
use App\Http\Requests\Buyer\UpdateBookingRequest;
use App\Http\Resources\Common\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingService
{
    /**
     * Store booking info
     *
     * @param  StoreBookingRequest $request
     * @return BookingResource
     */
    public function store(StoreBookingRequest $request): BookingResource
    {
        return new BookingResource(
            Booking::query()->create([
                'company_id' => $request->user()->company_id,
                'branch_id' => $request->user()->branch_id,
                ...$request->validated(),
            ])
        );
    }

    /**
     * Show booking info
     *
     * @param  Request         $request
     * @param  int             $id
     * @return BookingResource
     *
     * @throws NotFoundHttpException
     */
    public function show(Request $request, int $id): BookingResource
    {
        return new BookingResource(
            Booking::query()->findOrFail($id)->load([
                'ward.district.province',
                'branch',
                'employee',
            ])
        );
    }

    /**
     * Update booking info
     *
     * @param  UpdateBookingRequest $request
     * @param  int                  $id
     * @return BookingResource
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateBookingRequest $request, int $id): BookingResource
    {
        $booking = Booking::query()->findOrFail($id);
        $booking->update($request->validated());
        return new BookingResource($booking->load([
            'ward.district.province',
            'branch',
            'employee',
        ]));
    }

    /**
     * Delete booking info
     *
     * @param  Request $request
     * @param  int     $id
     * @return void
     */
    public function delete(Request $request, int $id): void
    {
        Booking::query()
            ->where('company_id', '=', $request->user()->company_id)
            ->findOrFail($id)
            ->delete();
    }
}
