<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request)
    {
        $this->smsService->twilioSendSms($request->phone);
        return $this->sendResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validation(Request $request)
    {
        if(!$this->smsService->twilioCheckSms($request->phone, $request->code)) {
            return $this->sendError();
        }
        return $this->sendResponse();
    }
}
