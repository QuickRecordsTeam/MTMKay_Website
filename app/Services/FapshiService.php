<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FapshiService
{
    protected string $baseUrl;
    protected string $apiUser;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.fapshi.base_url', env('FAPSHI_BASE_URL')), '/');
        $this->apiUser = env('FAPSHI_API_USER');
        $this->apiKey  = env('FAPSHI_API_KEY');
    }

    public function initiatePayment(array $data): array
    {
        try {
            $response = Http::withOptions([
                    'verify' => true, // disable SSL verify only for local testing
                    'timeout' => 30,
                ])
                ->withHeaders([
                    'apiUser' => $this->apiUser,
                    'apiKey'  => $this->apiKey,
                ])
                ->retry(3, 2000) // retry 3 times with 2s delay
                ->post("{$this->baseUrl}/direct-pay", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Fapshi API error", [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [
                'status'  => 'failed',
                'message' => 'Fapshi API returned error',
                'details' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error("Fapshi API connection error", [
                'message' => $e->getMessage(),
            ]);

            return [
                'status'  => 'failed',
                'message' => 'Connection to Fapshi API failed',
                'details' => $e->getMessage(),
            ];
        }
    }
}
