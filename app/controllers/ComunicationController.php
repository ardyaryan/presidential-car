<?php

class CommunicationController extends BaseController {

    const PROVIDER_SMS_EMAIL = '@vtext.com';

    public function __construct($cost = 0, $currency = '$') {
        $this->messageBody = 'Your trip with Presidential Car cost: ' . $currency . ' ' . round($cost, 2);
    }

    public function sendSmsToNumber($phoneNumber)
    {

        mail($phoneNumber . static::PROVIDER_SMS_EMAIL, '', $this->messageBody);
    }

    public function sendEmail($email)
    {
        mail($email, 'Presidential Car Trip', $this->messageBody);
    }

    public function sendGenericSmsToNumber($phoneNumber, $messageBody)
    {
        mail($phoneNumber . static::PROVIDER_SMS_EMAIL, '', $messageBody);
    }

    public function sendGenericEmail($email, $messageBody)
    {
        mail($email, 'Presidential Car Trip', $messageBody);
    }

}
