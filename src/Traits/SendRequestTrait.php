<?php

namespace Amsiam\SendSMS\Traits;

use Amsiam\SendSMS\Enums\ResponseMessage;
use Illuminate\Support\Facades\Http;

trait SendRequestTrait
{
    public function send(string $url, array $data, string $method = 'GET')
    {
        try {
            if ($method == 'POST') {
                $response = Http::post($url, $data);
            } else {
                $response = Http::get($url);
            }
            if ($response->successful()) {
                $data = json_decode($response->body(), true);


                $status = $this->statusCode[$data['response_code']] ?? ResponseMessage::UNKNOWN_ERROR;

                unset($data['response_code']);
                return [
                    'code' => $status->value,
                    'message' => $status->message(),
                    'data' => $data
                ];
            } else {
                throw new \Exception("Error: " . $response->body());
            }
        } catch (\Exception $e) {
            return [
                'code' => (ResponseMessage::UNKNOWN_ERROR)->value,
                'message' => $e->getMessage(),
            ];
        }
    }
}
