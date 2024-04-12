<?php

namespace App\Services\LP;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class LandingPageService
{
    protected Company $repository;

    public function __construct(Company $repository)
    {
        $this->repository = $repository;
    }

    public function storeCompany(array $data): Company
    {
        $company = DB::transaction(function () use ($data) {
            $company = $this->repository->create([
                'ward_id' => data_get($data, 'ward_id', null),
                'name' => data_get($data, 'name', null),
                'representative' => data_get($data, 'representative', null),
                'detail_address' => data_get($data, 'detail_address', null),
                'phone_number' => data_get($data, 'phone_number', null),
                'homepage_url' => data_get($data, 'homepage_url', null),
                'contact_person' => data_get($data, 'contact_person', null),
                'contact_email' => data_get($data, 'contact_email', null),
                'contact_phone_number' => data_get($data, 'contact_phone_number', null),
            ]);

            $branch = $company->branches()->create([
                'ward_id' => data_get($data, 'ward_id', null),
                'name' => data_get($data, 'name', null),
                'phone_number' => data_get($data, 'phone_number', null),
                'detail_address' => data_get($data, 'detail_address', null),
            ]);

            $branch->employees()->create([
                'company_id' => $branch->company_id,
                'name' => data_get($data, 'contact_person', null),
                'email' => data_get($data, 'contact_email', null),
                'phone_number' => data_get($data, 'contact_phone_number', null),
                'password' => bcrypt('@Abcd12345'),
            ]);

            return $company;
        });

        return $company;
    }
}
