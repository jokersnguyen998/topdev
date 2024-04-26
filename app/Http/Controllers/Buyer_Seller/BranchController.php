<?php

namespace App\Http\Controllers\Buyer_Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer_Seller\UpdateBranchRequest;
use App\Services\Buyer_Seller\BranchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends Controller
{
    protected BranchService $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    /**
     * List of branches
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $branches = $this->branchService->index($request);
        return response()->json($branches, Response::HTTP_OK);
    }

    /**
     * Show branch info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $branch = $this->branchService->show($request, $id);
        return response()->json($branch, Response::HTTP_OK);
    }

    /**
     * Update branch info
     *
     * @param  UpdateBranchRequest $request
     * @param  int                 $id
     * @return JsonResponse
     */
    public function update(UpdateBranchRequest $request, int $id): JsonResponse
    {
        $branch = $this->branchService->update($request, $id);
        return response()->json($branch, Response::HTTP_OK);
    }
}
