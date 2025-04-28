<?php

namespace Amsiam\SendSMS\Enums;

use Amsiam\SendSMS\Interfaces\ISendSMSDriver;

enum SMSDriver: string
{
    case BULK_SMS = 'bulk_sms';

    public function instance(): ISendSMSDriver
    {
        return match ($this) {
            self::BULK_SMS => new \Amsiam\SendSMS\Drivers\BulkSMSBDDriver(),
        };
    }
}
