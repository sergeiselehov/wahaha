<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if($user) {
            if(Hash::check($request->password, $user->password)) {
                $accessToken = $user->createToken('authToken')->accessToken;
                return $this->sendResponse($accessToken);
            } else {
                $error = ["password" => "Password mismatch."];
                return $this->sendError($error, 403);
            }
        } else {
            $error = ["user" =>'User does not exist.'];
            return $this->sendError($error, 403);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse();
    }

}
