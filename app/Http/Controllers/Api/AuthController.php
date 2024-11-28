<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helper\HelperResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Register Ne User.
     * @param App\Http\Requests\RegisterRequest $request
     * @return JSONResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user =  User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($user) return HelperResponse::success(message: 'User Has been created successfully', data: $user, statusCode: 201);
            return HelperResponse::error(message: ' Unable to Register user! Please try again.', statusCode: 404);
        } catch (\Throwable $th) {
            Log::error('Unable to Register User: ' . $th->getMessage() . ' - Line:' . $th->getLine());
            return HelperResponse::error(message: ' Unable to Register user! Please try again.' . $th->getMessage(), statusCode: 404);
            //throw $th;
        }
    }

    /**
     * Login User.
     * @param App\Http\Requests\LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return HelperResponse::error(message: 'Invalid credentials', statusCode: 401);
            }
            $user = Auth::user();

            $token = $user->createToken('authToken')->plainTextToken;

            return HelperResponse::success(message: 'User has been logged in successfully', data: ['user' => $user, 'token' => $token], statusCode: 200);
            $this->index($token);
        } catch (\Throwable $th) {
            Log::error('Unable to Login User: ' . $th->getMessage() . ' - Line:' . $th->getLine());
            return HelperResponse::error(message: ' Unable to Login! Please try again.' . $th->getMessage(), statusCode: 500);
        }
    }
    /**
     * Get authenticated user's profile.
     * @param NA
     * @return JSONResponse
     */
    public function userProfile()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return HelperResponse::success(message: 'User profile retrieved successfully', data: $user, statusCode: 200);
            }
            return HelperResponse::error(message: 'Unable to retrieve user profile! Please try again.', statusCode: 500);
        } catch (\Throwable $th) {
            Log::error('Unable to Retrieve User Profile: ' . $th->getMessage() . '- Line:' . $th->getLine());
            return HelperResponse::error(message: 'Unable to retrieve user profile! Please try again.', statusCode: 500);
        }
    }

    /**
     * Logout User.
     * @param NA
     * @return JSONResponse
     */
    public function logout()
    {
        try {
            $user = Auth::user();
            if (Auth::check()) {
                $user->currentAccessToken()->delete();
                return HelperResponse::success(message: 'User has been logged out successfully', data: $user, statusCode: 200);
            }
            return HelperResponse::error(message: 'Unable to Logout! Please try again.', statusCode: 500);
        } catch (\Throwable $th) {
            Log::error('Unable to Logout User: ' . $th->getMessage() . '- Line:' . $th->getLine());
            return HelperResponse::error(message: 'Unable to Logout! Please try again.', statusCode: 500);
        }
    }
}
