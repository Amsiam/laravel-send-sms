<?php

namespace Amsiam\SendSMS\Interfaces;

interface ISendSMSDriver
{
    public function sendSMS(string $phone, string $message);
    public function getBalance();
    public function sendSMSManyToMany(array $phones, array $messages);
    public function sendSMSOneToMany(array $phones, string $messages);
}
