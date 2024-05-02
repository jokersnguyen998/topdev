<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\StoreBookingRequest;
use App\Http\Requests\Buyer\UpdateBookingRequest;
use App\Services\Buyer\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Store booking info
     *
     * @param  StoreBookingRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        $booking = $this->bookingService->store($request);
        return response()->json($booking, Response::HTTP_CREATED);
    }

    /**
     * Show booking info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $booking = $this->bookingService->show($request, $id);
        return response()->json($booking, Response::HTTP_OK);
    }

    /**
     * Update booking info
     *
     * @param  UpdateBookingRequest $request
     * @param  int                  $id
     * @return JsonResponse
     */
    public function update(UpdateBookingRequest $request, int $id): JsonResponse
    {
        $booking = $this->bookingService->update($request, $id);
        return response()->json($booking, Response::HTTP_OK);
    }

    /**
     * Delete booking info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function delete(Request $request, int $id): JsonResponse
    {
        $this->bookingService->delete($request, $id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
