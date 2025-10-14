<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextLkService
{
    protected $base;
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->base = rtrim(config('services.textlk.base') ?? env('TEXTLK_API_BASE'), '/');
        $this->apiKey = config('services.textlk.key') ?? env('TEXTLK_API_KEY');
        $this->senderId = config('services.textlk.sender_id') ?? env('TEXTLK_SENDER_ID', 'TextLKDemo');
    }

    /**
     * Send SMS to single or multiple recipients.
     *
     * $recipients: string "9477xxxxxxx" or "9477...,9471..."
     */
    public function sendSms(string $recipients, string $message, ?string $scheduleTime = null): array
    {
        $payload = [
            'recipient' => $recipients,
            'sender_id' => $this->senderId,
            'type' => 'plain',
            'message' => $message,
        ];

        if ($scheduleTime) {
            $payload['schedule_time'] = $scheduleTime; // "YYYY-MM-DD HH:MM"
        }

        $url = $this->base . '/sms/send';

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->post($url, $payload);

        return [
            'status' => $response->status(),
            'body' => $response->json(),
        ];
    }
}