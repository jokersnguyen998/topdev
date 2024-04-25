<?php

namespace App\Http\Controllers\Buyer_Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer_Seller\StoreEmployeeRequest;
use App\Http\Requests\Buyer_Seller\UpdateEmployeeRequest;
use App\Services\Buyer_Seller\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * List of employees
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $employees = $this->employeeService->index($request);
        return response()->json($employees, Response::HTTP_OK);
    }

    /**
     * Store employee info
     *
     * @param  StoreEmployeeRequest $request
     * @return JsonResponse
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = $this->employeeService->store($request);
        return response()->json($employee, Response::HTTP_CREATED);
    }

    /**
     * Show employee info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $employee = $this->employeeService->show($request, $id);
        return response()->json($employee, Response::HTTP_OK);
    }

    /**
     * Update employee info
     *
     * @param  UpdateEmployeeRequest $request
     * @param  int                   $id
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        $this->employeeService->update($request, $id);
        return response()->json()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Delete employee info
     *
     * @param  Request      $request
     * @param  int          $id
     * @return JsonResponse
     */
    public function delete(Request $request, int $id): JsonResponse
    {
        $this->employeeService->delete($request, $id);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
