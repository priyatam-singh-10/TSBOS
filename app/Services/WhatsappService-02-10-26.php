<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected $api_url;
    protected $instance_id;
    protected $access_token;

    public function __construct()
    {
        $this->api_url = config('services.whatsapp.api_url');
        $this->instance_id = config('services.whatsapp.instance_id');
        $this->access_token = config('services.whatsapp.access_token');
    }

    /**
     * Build WhatsApp send URL from env/config.
     * Pass raw message (not urlencoded) — encoding is handled here.
     */
    public static function buildUrl($number, $message)
    {
        $number = preg_replace('/\D+/', '', (string) $number);

        return config('services.whatsapp.api_url') . '?' . http_build_query([
            'number' => $number,
            'type' => 'text',
            'message' => $message,
            'instance_id' => config('services.whatsapp.instance_id'),
            'access_token' => config('services.whatsapp.access_token'),
        ]);
    }

    public function send($number, $message)
    {
        $number = preg_replace('/\D+/', '', (string) $number);

        $response = Http::get($this->api_url, [
            'number' => $number,
            'type' => 'text',
            'message' => $message,
            'instance_id' => $this->instance_id,
            'access_token' => $this->access_token,
        ]);

        return $response;
    }

    /**
     * Send via file_get_contents (same pattern used across the app).
     */
    public static function sendViaGet($number, $message)
    {
        $url = self::buildUrl($number, $message);

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 20,
                    'ignore_errors' => true,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $response = @file_get_contents($url, false, $context);
            if ($response === false) {
                Log::error('WhatsApp send failed: no response', ['number' => $number]);
            }
            return $response;
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getMessage());
            return false;
        }
    }

    public function webinarPurchase($user, $webinar)
    {
        $message = "Hello {$user->name}, Your registration for the webinar {$webinar->title} has been successfully confirmed. Date: {$webinar->date} Time: {$webinar->time} Speaker: {$webinar->speaker} Join Link: {$webinar->join_link} Please join 10 minutes before the scheduled time. Regards, The Sommnath Bhattacharyaa Occult Sciences";
        return $this->send($user->phone, $message);
    }
}
