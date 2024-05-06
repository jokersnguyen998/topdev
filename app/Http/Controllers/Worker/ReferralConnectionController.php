<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\StoreReferralConnectionRequest;
use App\Services\Worker\ReferralConnectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReferralConnectionController extends Controller
{
    protected ReferralConnectionService $referralConnectionService;

    public function __construct(ReferralConnectionService $referralConnectionService)
    {
        $this->referralConnectionService = $referralConnectionService;
    }

    /**
     * List of referral connections
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $referralConnections = $this->referralConnectionService->index($request);
        return response()->json($referralConnections, Response::HTTP_OK);
    }

    /**
     * Store referral connection info
     *
     * @param  StoreReferralConnectionRequest $request
     * @return JsonResponse
     */
    public function store(StoreReferralConnectionRequest $request): JsonResponse
    {
        $referralConnection = $this->referralConnectionService->store($request);
        return response()->json($referralConnection, Response::HTTP_CREATED);
    }

    public function delete(Request $request, int $id): JsonResponse
    {
        $this->referralConnectionService->delete($request, $id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
