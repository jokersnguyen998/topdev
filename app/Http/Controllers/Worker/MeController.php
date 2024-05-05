<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\AcademicLevelRequest;
use App\Http\Requests\Worker\LicenseRequest;
use App\Http\Requests\Worker\InfoRequest;
use App\Http\Requests\Worker\SkillRequest;
use App\Http\Requests\Worker\WorkExperienceRequest;
use App\Services\Worker\MeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    protected MeService $meService;

    public function __construct(MeService $meService)
    {
        $this->meService = $meService;
    }

    /**
     * Update academic levels info
     *
     * @param  AcademicLevelRequest $request
     * @return JsonResponse
     */
    public function updateAcademicLevel(AcademicLevelRequest $request): JsonResponse
    {
        $worker = $this->meService->updateAcademicLevel($request);
        return response()->json($worker, Response::HTTP_OK);
    }

    /**
     * Update work experiences info
     *
     * @param  WorkExperienceRequest $request
     * @return JsonResponse
     */
    public function updateWorkExperience(WorkExperienceRequest $request): JsonResponse
    {
        $worker = $this->meService->updateWorkExperience($request);
        return response()->json($worker, Response::HTTP_OK);
    }

    /**
     * Update licenses info
     *
     * @param  LicenseRequest $request
     * @return JsonResponse
     */
    public function updateLicense(LicenseRequest $request): JsonResponse
    {
        $worker = $this->meService->updateLicense($request);
        return response()->json($worker, Response::HTTP_OK);
    }

    /**
     * Update skill info
     *
     * @param  SkillRequest $request
     * @return JsonResponse
     */
    public function updateSkill(SkillRequest $request): JsonResponse
    {
        $worker = $this->meService->updateSkill($request);request:
        return response()->json($worker, Response::HTTP_OK);
    }

    public function updateInfo(InfoRequest $request): JsonResponse
    {
        $worker = $this->meService->updateInfo($request);
        return response()->json($worker, Response::HTTP_OK);
    }
}
