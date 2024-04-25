<?php

namespace App\Services\Buyer_Seller;

use App\Http\Requests\Buyer_Seller\StoreEmployeeRequest;
use App\Http\Requests\Buyer_Seller\UpdateEmployeeRequest;
use App\Http\Resources\Buyer_Seller\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeService
{
    /**
     * List of employees
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return EmployeeResource::collection(
            $request->user()->company->employees()->with([
                'ward.district.province',
                'branch',
                'company',
            ])->get()
        );
    }

    /**
     * Store employee info
     *
     * @param  StoreEmployeeRequest $request
     * @return EmployeeResource
     */
    public function store(StoreEmployeeRequest $request): EmployeeResource
    {
        return new EmployeeResource(Employee::query()->create($request->validated()));
    }

    /**
     * Show employee info
     *
     * @param  Request          $request
     * @param  int              $id
     * @return EmployeeResource
     *
     * @throws NotFoundHttpException
     */
    public function show(Request $request, int $id): EmployeeResource
    {
        return new EmployeeResource(
            $request->user()->company->employees()->with([
                'ward.district.province',
                'branch',
                'company',
            ])->findOrFail($id)
        );
    }

    /**
     * Update employee info
     *
     * @param  UpdateEmployeeRequest $request
     * @param  int                   $id
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function update(UpdateEmployeeRequest $request, int $id): void
    {
        Employee::query()->findOrFail($id)->update($request->validated());
    }

    /**
     * Delete employee info
     *
     * @param  Request $request
     * @param  int     $id
     * @return void
     *
     * @throws NotFoundHttpException
     */
    public function delete(Request $request, int $id): void
    {
        $request->user()->company->employees()->whereKeyNot($request->user()->id)->findOrFail($id)->delete();
    }
}
