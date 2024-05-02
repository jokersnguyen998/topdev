<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\StoreMeetingRoomRequest;
use App\Http\Requests\Buyer\UpdateMeetingRoomRequest;
use App\Services\Buyer\MeetingRoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingRoomController extends Controller
{
    protected MeetingRoomService $meetingRoomService;

    public function __construct(MeetingRoomService $meetingRoomService)
    {
        $this->meetingRoomService = $meetingRoomService;
    }

    /**
     * List of meeting rooms
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $meetingRooms = $this->meetingRoomService->index($request);
        return response()->json($meetingRooms, Response::HTTP_OK);
    }

    /**
     * Store meeting room info
     *
     * @param  StoreMeetingRoomRequest $request
     * @return JsonResponse
     */
    public function store(StoreMeetingRoomRequest $request): JsonResponse
    {
        $meetingRoom = $this->meetingRoomService->store($request);
        return response()->json($meetingRoom, Response::HTTP_CREATED);
    }

    /**
     * Show meeting room info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $meetingRoom = $this->meetingRoomService->show($request, $id);
        return response()->json($meetingRoom, Response::HTTP_OK);
    }

    /**
     * Update meeting room info
     *
     * @param  UpdateMeetingRoomRequest $request
     * @param  int                      $id
     * @return JsonResponse
     */
    public function update(UpdateMeetingRoomRequest $request, int $id): JsonResponse
    {
        $meetingRoom = $this->meetingRoomService->update($request, $id);
        return response()->json($meetingRoom, Response::HTTP_OK);
    }

    /**
     * Delete meeting room info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function delete(Request $request, int $id): JsonResponse
    {
        $this->meetingRoomService->delete($request, $id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
