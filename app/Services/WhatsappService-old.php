<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    protected $api_url;
    public function __construct()
    {
        $this->api_url = "https://511.wazipers.com/api/send";
    }
    public function send($number, $message)
    {
        $number = str_replace('+', '', $number);
        $response = Http::get($this->api_url, ['number' => $number, 'type' => 'text', 'message' => $message, 'instance_id' => '6A687EE3B3B2F', 'access_token' => '6a4f950a626af',]);
        return $response;
    }
    public function webinarPurchase($user, $webinar)
    {
        $message = "Hello {$user->name}, Your registration for the webinar {$webinar->title} has been successfully confirmed. Date: {$webinar->date} Time: {$webinar->time} Speaker: {$webinar->speaker} Join Link: {$webinar->join_link} Please join 10 minutes before the scheduled time. Regards, The Sommnath Bhattacharyaa Occult Sciences";
        return $this->send($user->phone, $message);
    }
}

