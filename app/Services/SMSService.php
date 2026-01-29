<?php
namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SMSService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $this->from = config('services.twilio.from');
    }

    public function send($mobile, $message, $from = null)
    {
        try {
            $sms = $this->client->messages->create(
                $mobile, // +91XXXXXXXXXX
                [
                    'from' => $from ?? $this->from,
                    'body' => $message
                ]
            );

            Log::info('Twilio SMS Sent', ['sid' => $sms->sid]);
            return true;

        } catch (\Exception $e) {
            Log::error('Twilio SMS Error', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
