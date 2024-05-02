<?php

namespace App\Services\Buyer;

use App\Http\Requests\Buyer\StoreMeetingRoomRequest;
use App\Http\Requests\Buyer\UpdateMeetingRoomRequest;
use App\Http\Resources\Buyer\MeetingRoomResource;
use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MeetingRoomService
{
    /**
     * List of meeting rooms
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return MeetingRoomResource::collection(
            MeetingRoom::query()
                ->where('company_id', '=', $request->user()->company_id)
                ->with(['ward.district.province'])
                ->get()
        );
    }

    /**
     * Store meeting room info
     *
     * @param  StoreMeetingRoomRequest $request
     * @return MeetingRoomResource
     */
    public function store(StoreMeetingRoomRequest $request): MeetingRoomResource
    {
        return new MeetingRoomResource(MeetingRoom::query()->create([
            'company_id' => $request->user()->company_id,
            ...$request->validated(),
        ]));
    }

    /**
     * Show meeting room info
     *
     * @param  Request             $request
     * @param  int                 $id
     * @return MeetingRoomResource
     *
     * @throws NotFoundHttpException
     */
    public function show(Request $request, int $id): MeetingRoomResource
    {
        return new MeetingRoomResource(
            MeetingRoom::query()
                ->where('company_id', '=', $request->user()->company_id)
                ->findOrFail($id)
                ->load(['ward.district.province'])
        );
    }

    /**
     * Update meeting room info
     *
     * @param  UpdateMeetingRoomRequest $request
     * @param  int                      $id
     * @return MeetingRoomResource
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateMeetingRoomRequest $request, int $id): MeetingRoomResource
    {
        $meetingRoom = MeetingRoom::query()->where('company_id', '=', $request->user()->company_id)->findOrFail($id);
        $meetingRoom->update($request->validated());
        return new MeetingRoomResource($meetingRoom->load(['ward.district.province']));
    }

    /**
     * Delete meeting room info
     *
     * @param  Request $request
     * @param  int     $id
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function delete(Request $request, int $id): void
    {
        MeetingRoom::query()
            ->where('company_id', '=', $request->user()->company_id)
            ->findOrFail($id)
            ->delete();
    }
}
