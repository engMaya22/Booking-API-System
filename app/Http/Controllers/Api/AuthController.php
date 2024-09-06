<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
class AuthController extends BaseController

{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        $success['user'] =  $user;
   
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(LoginRequest $request)
    {
        
        $validated = $request->validated();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }

        return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
    }


   
}
