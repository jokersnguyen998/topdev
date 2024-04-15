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
                'email' => 'required|email|exists:employees,email|max:100',
                'password' => 'required|max:255',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!Auth::guard('employee')->attempt($request->only(['email', 'password']))){
            return response()->json([
                'message' => 'Email & Password does not match with our record.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $employee = Employee::query()->where('email', '=', $request->email)->first();

        return response()->json([
            'message' => 'User Logged In Successfully',
            'token' => $employee->createToken("EMPLOYEE TOKEN")->plainTextToken
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
