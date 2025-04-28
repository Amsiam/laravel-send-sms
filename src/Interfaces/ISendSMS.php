<?php

namespace Amsiam\SendSMS\Interfaces;

interface ISendSMS
{
    /**
     * Send an SMS message.
     *
     * @param string $phone
     * @param string $message
     * @return mixed
     */
    public function sendSMS(string $phone, string $message);
}
