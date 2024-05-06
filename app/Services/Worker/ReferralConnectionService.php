<?php

namespace App\Services\Worker;

use App\Http\Requests\Worker\StoreReferralConnectionRequest;
use App\Http\Resources\Worker\ReferralConnectionResource;
use App\Models\Company;
use App\Models\ReferralConnection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReferralConnectionService
{
    /**
     * List of referral connections
     *
     * @param  Request                     $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return ReferralConnectionResource::collection(
            $request->user()->referralConnections()->with(['company.ward.district.province'])->get()
        );
    }

    /**
     * Store referral connection info
     *
     * @param  StoreReferralConnectionRequest $request
     * @return ReferralConnectionResource
     */
    public function store(StoreReferralConnectionRequest $request): ReferralConnectionResource
    {
        $company = Company::query()
            ->where('contact_email', '=', base64_decode($request->hash_url))
            ->firstOrFail('id');

        $referralConnection = ReferralConnection::query()
            ->updateOrCreate([
                'worker_id' => $request->user()->id,
                'company_id' => $company->id,
            ], [
                'worker_id' => $request->user()->id,
                'company_id' => $company->id,
            ]);

        return new ReferralConnectionResource($referralConnection->load('company'));
    }

    /**
     * Delete referral connection info
     *
     * @param  Request $request
     * @param  int     $id
     * @return void
     */
    public function delete(Request $request, int $id): void
    {
        $request->user()->referralConnections()->findOrFail($id)->delete();
    }
}
