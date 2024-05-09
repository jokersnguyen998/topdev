<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\ImportRecruitmentRequest;
use App\Http\Requests\Buyer\StoreRecruitmentRequest;
use App\Http\Requests\Buyer\UpdateRecruitmentRequest;
use App\Services\Buyer\RecruitmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class RecruitmentController extends Controller
{
    protected RecruitmentService $recruitmentService;

    public function __construct(RecruitmentService $recruitmentService)
    {
        $this->recruitmentService = $recruitmentService;
    }

    /**
     * List of recruitments
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $recruitments = $this->recruitmentService->index($request);
        return response()->json($recruitments, Response::HTTP_OK);
    }

    /**
     * Store recruitment info
     *
     * @param  StoreRecruitmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreRecruitmentRequest $request): JsonResponse
    {
        $recruitment = $this->recruitmentService->store($request);
        return response()->json($recruitment, Response::HTTP_CREATED);
    }

    /**
     * Show recruitment info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $recruitment = $this->recruitmentService->show($request, $id);
        return response()->json($recruitment, Response::HTTP_OK);
    }

    /**
     * Update recruitment info
     *
     * @param  UpdateRecruitmentRequest $request
     * @param  int                      $id
     * @return JsonResponse
     */
    public function update(UpdateRecruitmentRequest $request, int $id): JsonResponse
    {
        $recruitment = $this->recruitmentService->update($request, $id);
        return response()->json($recruitment, Response::HTTP_OK);
    }

    /**
     * Export recruitment info
     *
     * @param  Request            $request
     * @return BinaryFileResponse
     */
    public function export(Request $request): BinaryFileResponse
    {
        return response()->download(
            $this->recruitmentService->export($request, 'recruitment.csv')
        )->deleteFileAfterSend();
    }

    /**
     * Import recruitment info
     * 
     * @param  ImportRecruitmentRequest $request
     * @return JsonResponse
     */
    public function import(ImportRecruitmentRequest $request): JsonResponse
    {
        $this->recruitmentService->import($request);
        return response()->json()->setStatusCode(Response::HTTP_OK);
    }
}
