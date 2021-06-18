<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    protected $service;

    public function __construct()
    {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $token);
        $this->service = $twilio->verify->v2->services($twilio_verify_sid);
    }

    /**
     * Twilio sending a message.
     *
     * @param $phone
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function twilioSendSms($phone)
    {
        $this->service->verifications->create($phone, "sms");
    }

    /**
     * Twilio check message.
     *
     * @param $phone
     * @param $code
     * @return bool
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function twilioCheckSms($phone, $code)
    {
        $this->validation($this->service->verificationChecks
            ->create($code, ['to' => $phone]));

        return true;
    }

    /**
     * Service response validation.
     *
     * @param $verification
     * @return false
     */
    public function validation($verification)
    {
        if(!$verification->valid) {
            return false;
        }
    }
}
