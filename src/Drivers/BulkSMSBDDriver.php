<?php

namespace Amsiam\SendSMS\Drivers;

use Amsiam\SendSMS\Enums\ResponseMessage;
use Amsiam\SendSMS\Interfaces\ISendSMSDriver;
use Amsiam\SendSMS\Traits\SendRequestTrait;

class BulkSMSBDDriver implements ISendSMSDriver
{
    use SendRequestTrait;
    protected $apiKey;
    protected $senderID;
    protected $apiUrl = "http://bulksmsbd.net/api/";

    private array $statusCode = [
        202 => ResponseMessage::SMS_SENT,
        1002 => ResponseMessage::INVALID_SENDER,
        1003 => ResponseMessage::MISSING_FIELDS,
        1005 => ResponseMessage::SERVER_ERROR,
        1006 => ResponseMessage::NO_VALIDITY,
        1007 => ResponseMessage::LOW_BALANCE,
        1011 => ResponseMessage::USER_NOT_FOUND,
        1012 => ResponseMessage::BENGALI_REQUIRED,
        1013 => ResponseMessage::NO_GATEWAY,
        1014 => ResponseMessage::SENDER_TYPE_NOT_FOUND,
        1015 => ResponseMessage::NO_VALID_GATEWAY,
        1016 => ResponseMessage::NO_ACTIVE_PRICE,
        1017 => ResponseMessage::NO_PRICE_INFO,
        1018 => ResponseMessage::ACCOUNT_DISABLED,
        1019 => ResponseMessage::PRICE_DISABLED,
        1020 => ResponseMessage::PARENT_NOT_FOUND,
        1021 => ResponseMessage::NO_PARENT_PRICE,
    ];

    public function __construct()
    {
        $this->apiKey = config('sendsms.drivers.bulk_sms.api_key');
        $this->senderID = config('sendsms.drivers.bulk_sms.sender_id');
    }

    public function getBalance()
    {
        $url = $this->apiUrl . "getBalanceApi?api_key=" . $this->apiKey;
        return $this->send($url, []);
    }

    public function sendSMS(string $phone, string $message)
    {
        $url = $this->apiUrl . "smsapi?api_key=" . $this->apiKey . "&senderid=" . $this->senderID .
            "&type=text&message=" . urlencode($message) . "&number=" . $phone;

        return $this->send($url, []);
    }

    public function sendSMSManyToMany(array $phones, array $messages)
    {
        $data = [];
        for ($index = 0; $index < count($phones); $index++) {
            $data[] = [
                'to' => $phones[$index],
                'message' => $messages[$index]
            ];
        }
        $url = $this->apiUrl . "smsapimany";
        $messages = json_encode($data);
        $postdata = [
            "api_key" => $this->apiKey,
            "senderid" => $this->senderID,
            "messages" => $messages
        ];
        return $this->send($url, $postdata, 'POST');
    }

    public function sendSMSOneToMany(array $phones, string $messages)
    {
        return $this->sendSMS(implode(',', $phones), $messages);
    }
}
