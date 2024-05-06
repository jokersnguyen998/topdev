<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\ReferralConnection;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Register
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = validator(
            $request->all(),
            [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:workers,email|max:100',
                'password' => 'required|max:255',
                'phone_number' => 'required|max:20',
                'birthday' => 'required|date_format:Y-m-d',
                'detail_address' => 'nullable|max:255',
                'avatar_url' => 'nullable|max:255',
                'contact_detail_address' => 'nullable|max:255',
                'contact_phone_number' => 'nullable|max:20',
                'hash_url' => [
                    'required',
                    function (string $attribute, mixed $value, \Closure $fail) {
                        $company = Company::query()
                            ->where('contact_email', '=', base64_decode($value))
                            ->first('id');

                        if (is_null($company)) {
                            $fail("The selected :attribute is invalid.");
                        }
                    }
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $company = Company::query()
            ->where('contact_email', '=', base64_decode($request->hash_url))
            ->first('id');

        $worker = DB::transaction(function () use ($request, $company) {
            $worker = Worker::query()->create(
                $request->only([
                    'ward_id',
                    'contact_ward_id',
                    'name',
                    'email',
                    'password',
                    'phone_number',
                    'gender',
                    'birthday',
                    'detail_address',
                    'avatar_url',
                    'contact_detail_address',
                    'contact_phone_number',
                ])
            );

            ReferralConnection::query()->create([
                'worker_id' => $worker->id,
                'company_id' => $company->id,
                'is_first' => 1,
            ]);

            return $worker;
        });

        return response()->json([
            'message' => 'User Created Successfully',
            'token' => $worker->createToken("WORKER TOKEN")->plainTextToken
        ], Response::HTTP_CREATED);
    }

    /**
     * Login
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = validator(
            $request->all(),
            [
                'email' => 'required|email|exists:workers,email|max:100',
                'password' => 'required|max:255',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!Auth::guard('worker')->attempt($request->only(['email', 'password']))){
            return response()->json([
                'message' => 'Email & Password does not match with our record.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = DB::transaction(function () use ($request) {
            $worker = Worker::query()->where('email', '=', $request->email)->first();
            $worker->update(['last_login_at' => now()]);
            return $worker->createToken("WORKER TOKEN")->plainTextToken;
        });

        return response()->json([
            'message' => 'User Logged In Successfully',
            'token' => $token,
        ], Response::HTTP_OK);
    }

    /**
     * Logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json();
    }
}
