<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WahaService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('WAHA_URL', 'http://72.61.208.130:3000');
        $this->apiKey  = env('WAHA_API_KEY', '0f0eb5d196b6459781f7d854aac5050e');
    }

    public function sendText($to, $message)
    {
        try {
            // 1. Format Nomor HP (08xx -> 628xx)
            if (str_starts_with($to, '08')) {
                $to = '62' . substr($to, 1);
            }
            
            // 2. Pastikan akhiran @c.us ada
            if (!str_ends_with($to, '@c.us')) {
                $to = $to . '@c.us';
            }

            // 3. Kirim Request ke WAHA dengan Header X-Api-Key
            $response = Http::withHeaders([
                'X-Api-Key'    => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->post($this->baseUrl . '/api/sendText', [
                'session' => 'default', // Pastikan session 'default' statusnya SCANNING/WORKING di dashboard WAHA
                'chatId'  => $to,
                'text'    => $message,
            ]);

            // 4. Cek apakah sukses
            if ($response->successful()) {
                return true;
            } else {
                // Log error jika gagal (untuk debugging)
                Log::error('WAHA Gagal: ' . $response->body());
                return false;
            }

        } catch (\Exception $e) {
            Log::error('WAHA Exception: ' . $e->getMessage());
            return false;
        }
    }
}