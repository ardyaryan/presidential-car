<?php

class CommunicationController extends BaseController {

    const PROVIDER_SMS_EMAIL = '@vtext.com';
    const COMPANY_FROM_EMAIL = 'do-not-reply@presidential-car.com';
    const COMPANY_FROM_NAME = 'Presidential Car';

    public function __construct($cost = 0, $currency = '$') {
        $this->messageBody = 'Your trip with Presidential Car cost: ' . $currency . ' ' . round($cost, 2);
    }

    public static function sendSmsToNumber($phoneNumber, $messageBody)
    {
        Mail::send('emails.sms', ['messageBody' => $messageBody], function ($message) use ($phoneNumber){
            $message->from(static::COMPANY_FROM_EMAIL, static::COMPANY_FROM_NAME);
            $message->to($phoneNumber . static::PROVIDER_SMS_EMAIL, 'something')->subject('');
        });
    }

    public static function sendEmail($email, $messageBody, $emailView, $subject = 'Test Email')
    {
        Mail::send($emailView, ['messageBody' => $messageBody], function ($message) use ($email, $subject) {
            $message->from(static::COMPANY_FROM_EMAIL, static::COMPANY_FROM_NAME);
            $message->to($email, '')->subject($subject);
        });
    }

}
