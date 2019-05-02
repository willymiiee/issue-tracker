<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Services\UserService;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Authentication
 *
 * API for authentication
 */
class AuthController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Login
     *
     * API for user to log in
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            if (!$token = $this->jwt->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                return response()->json(['error' => 'User not found!'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expired!'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token Invalid!'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => new UserResource($this->jwt->user())
        ]);
    }

    /**
     * Register
     *
     * API for anyone to register a new company
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|max:16'
        ]);

        $userService = new UserService;

        $input = $request->except(['password_confirmation']);
        $input['password'] = app('hash')->make($input['password']);

        try {
            $user = $userService->create($input);
            $token = $this->jwt->attempt([
                'email' => $input['email'],
                'password' => $request->password,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $result = [
            'token' => $token,
            'user' => new UserResource($this->jwt->user())
        ];

        return response()->json($result, 200);
    }
}
