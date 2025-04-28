<?php

namespace Amsiam\SendSMS;

use Amsiam\SendSMS\Drivers\BulkSMSBDDriver;
use Amsiam\SendSMS\Enums\SMSDriver;
use Amsiam\SendSMS\Interfaces\ISendSMS;
use Amsiam\SendSMS\Interfaces\ISendSMSDriver;
use BadMethodCallException;

class SendSMS implements ISendSMS
{

    private ?ISendSMSDriver $driver;
    public function __construct()
    {
        $defaultDriver = config('sendsms.default');
        $this->setDriver(SMSDriver::from($defaultDriver));
    }

    public function setDriver(SMSDriver $driver)
    {
        $this->driver = $driver->instance();
        return $this;
    }

    public function sendSMS(string $phone, string $message)
    {
        return $this->driver?->sendSMS($phone, $message);
    }

    public function sendOneMessageToMany(array $phones, string $message)
    {
        return $this->driver?->sendSMSOneToMany($phones, $message);
    }

    public function sendManyMessageToMany(array $phones, array $messages)
    {
        return $this->driver?->sendSMSManyToMany($phones,  $messages);
    }

    public function getBalance()
    {
        return $this->driver?->getBalance();
    }

    public static function __callStatic($method, $arguments)
    {
        // Create an instance of the class
        $instance = new self();

        // Check if the method exists in the instance
        if (method_exists($instance, $method)) {
            // Call the non-static method on the instance
            return call_user_func_array([$instance, $method], $arguments);
        }

        // Throw an exception if the method doesn't exist
        throw new BadMethodCallException("Static call to undefined method $method");
    }
}
