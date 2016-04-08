<?php

class CommunicationController extends BaseController {

    const PROVIDER_SMS_EMAIL = '@vtext.com';

    public function __construct($cost, $currency) {
        $this->messageBody = 'Your trip with Presidential Car cost: ' . $currency . ' ' . round($cost, 2);
    }

    public function sendSmsToNumber ($phoneNumber)
    {

        mail($phoneNumber . '@vtext.com', '', $this->messageBody);
    }

    public function sendEmail ($email)
    {
        mail($email, 'Presidential Car Trip', $this->messageBody);
    }

}
