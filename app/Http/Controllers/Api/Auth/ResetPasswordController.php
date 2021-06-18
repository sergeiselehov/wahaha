<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetPassword(Request $request)
    {
        $smsService = new SmsService;
        if(!$smsService->twilioCheckSms($request->phone, $request->code)) {
            return $this->sendError();
        }

        $request['token'] = Str::random(32);
        $passwordReset = DB::table('password_resets');
        $passwordReset->create($request->toArray());
        return $this->sendResponse($request['token']);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $passwordReset = DB::table('password_resets');
        $exist = $passwordReset->where('token', $token)->exists();

        if(!$exist) {
            $error = ["token" => 'Token is not valid.'];
            return $this->sendError($error);
        }

        $user = User::where('phone', $request->phone)->first();

        if(!$user) {
            $error = ["user" =>'User does not exist.'];
            return $this->sendError($error);
        }

        $user->password = $request->password;
        $user->save();
        return $this->sendResponse();
    }
}
