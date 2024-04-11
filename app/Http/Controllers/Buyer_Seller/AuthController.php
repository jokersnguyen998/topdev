<?php

namespace App\Http\Controllers\Buyer_Seller;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $validator = validator([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:employees,email|max:100',
            'password' => 'required|max:255',
            'phone_number' => 'required|max:20',
            'detail_address' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $employee = Employee::query()->create(
            $request->only([
                'name',
                'email',
                'password',
                'phone_number',
                'detail_address',
            ])
        );

        return response()->json([
            'message' => 'User Created Successfully',
            'token' => $employee->createToken("API TOKEN")->plainTextToken
        ], Response::HTTP_CREATED);
    }

    /**
     * Login The User
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = validator([
            'email' => 'required|email|unique:employees,email|max:100',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'message' => 'Email & Password does not match with our record.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $employee = Employee::query()->where('email', '=', $request->email)->first();

        return response()->json([
            'message' => 'User Logged In Successfully',
            'token' => $employee->createToken("API TOKEN")->plainTextToken
        ], Response::HTTP_OK);
    }
}
