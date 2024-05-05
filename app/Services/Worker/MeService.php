<?php

namespace App\Services\Worker;

use App\Http\Requests\Worker\AcademicLevelRequest;
use App\Http\Requests\Worker\InfoRequest;
use App\Http\Requests\Worker\LicenseRequest;
use App\Http\Requests\Worker\SkillRequest;
use App\Http\Requests\Worker\WorkExperienceRequest;
use App\Http\Resources\Worker\MeResource;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class MeService
{
    /**
     * Update academic levels info
     *
     * @param  AcademicLevelRequest $request
     * @return MeResource
     */
    public function updateAcademicLevel(AcademicLevelRequest $request): MeResource
    {
        DB::transaction(function () use ($request) {
            $request->user()->academicLevels()->delete();
            $request->user()->academicLevels()->createMany($request->validated());
        });

        return new MeResource(
            $request->user()->load([
                'academicLevels',
            ])
        );
    }

    /**
     * Update work experiences info
     *
     * @param  WorkExperienceRequest $request
     * @return MeResource
     */
    public function updateWorkExperience(WorkExperienceRequest $request): MeResource
    {
        DB::transaction(function () use ($request) {
            $request->user()->workExperiences()->delete();
            $request->user()->workExperiences()->createMany($request->validated());
        });

        return new MeResource(
            $request->user()->load([
                'workExperiences',
            ])
        );
    }

    /**
     * Update licenses info
     *
     * @param  LicenseRequest $request
     * @return MeResource
     */
    public function updateLicense(LicenseRequest $request): MeResource
    {
        DB::transaction(function () use ($request) {
            $request->user()->licenses()->delete();
            $request->user()->licenses()->createMany($request->validated());
        });

        return new MeResource(
            $request->user()->load([
                'licenses',
            ])
        );
    }

    /**
     * Update skill info
     *
     * @param  SkillRequest $request
     * @return MeResource
     */
    public function updateSkill(SkillRequest $request): MeResource
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $jobCareers = array_pop($data);

            $skill = Skill::query()->updateOrCreate([
                'worker_id' => $request->user()->id
            ], $data);

            $skill->jobCareers()->delete();
            if (!empty($jobCareers)) {
                $skill->jobCareers()->createMany($jobCareers);
            }
        });

        return new MeResource(
            $request->user()->load([
                'skill.jobCareers',
            ])
        );
    }

    /**
     * Update worker info
     * 
     * @param  InfoRequest $request
     * @return MeResource
     */
    public function updateInfo(InfoRequest $request): MeResource
    {
        $request->user()->update($request->validated());
        return new MeResource($request->user()->load([
            'ward.district.province',
            'contactWard.district.province',
        ]));
    }
}
