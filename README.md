# SendSMS Laravel Package

## Overview
The `Amsiam\SendSMS` package provides a simple and flexible way to send SMS messages in Laravel applications. It supports multiple SMS drivers and allows sending single messages, one message to multiple recipients, or multiple messages to multiple recipients. Additionally, it provides functionality to check the SMS balance for the configured driver.
---

## Table of Contents
1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
   - [Setting a Driver](#setting-a-driver)
   - [Sending a Single SMS](#sending-a-single-sms)
   - [Sending One Message to Multiple Recipients](#sending-one-message-to-multiple-recipients)
   - [Sending Multiple Messages to Multiple Recipients](#sending-multiple-messages-to-multiple-recipients)
   - [Checking SMS Balance](#checking-sms-balance)
   - [Static Method Calls](#static-method-calls)
5. [Supported Drivers](#supported-drivers)
6. [Error Handling](#error-handling)
7. [Support](#support)

---

## Requirements
- **PHP**: 7.4 or higher
- **Laravel**: 8.x or higher
- **Composer**: For package installation
- A valid account with a supported SMS provider (e.g., BulkSMSBD)

---

## Installation
1. Install the package via Composer:
   ```bash
   composer require amsiam/send-sms
   ```

2. Publish the configuration file (optional):
   ```bash
   php artisan vendor:publish --provider="Amsiam\SendSMS\SendSMSServiceProvider"
   ```
   This will create a `config/sendsms.php` file in your Laravel project.

3. **Register the Facade**(optional):
   Add the `SendSMS` facade to your `config/app.php` file under the `aliases` array:

   ```php
   'aliases' => [
       // Other aliases...
       'SendSMS' => Amsiam\SendSMS\Facades\SendSMS::class,
   ],
   ```

---

## Configuration
The package uses a configuration file (`config/sendsms.php`) to set the default SMS driver and driver-specific settings. Below is an example configuration:

```php
<?php

return [
    'default' => env('SMS_DRIVER', 'bulk_sms'),

    'drivers' => [
        'bulk_sms' => [
            'api_key' => env('SMS_BULK_SMS_BD_API_KEY'),
            'sender_id' => env('SMS_BULK_SMS_BD_SENDERID'),
        ],
        // Add other drivers here
    ],
];
```

### Environment Variables
Add the following to your `.env` file to configure the driver:

```env
SMS_DRIVER=bulk_sms
SMS_BULK_SMS_BD_API_KEY=your_api_key
SMS_BULK_SMS_BD_SENDERID=your_sender_id
```

### Available Configuration Options
- `default`: The default SMS driver (e.g., `bulk_sms`).
- `drivers`: An array of driver-specific configurations, such as API keys and base URLs.

---

## Usage
The `SendSMS` class provides methods to send SMS messages and check balances. You can use it via the `Amsiam\SendSMS\Facades\SendSMS` facade, which simplifies imports and usage.

### Setting a Driver
By default, the package uses the driver specified in the `default` configuration. To switch drivers programmatically:

```php
use Amsiam\SendSMS\Enums\SMSDriver;
use Amsiam\SendSMS\Facades\SendSMS;

SendSMS::setDriver(SMSDriver::BULK_SMS);
```

### Sending a Single SMS
Send an SMS to a single phone number:

```php
use Amsiam\SendSMS\Facades\SendSMS;

$response = SendSMS::sendSMS('8801234567890', 'Hello, this is a test message!');
```

### Sending One Message to Multiple Recipients
Send the same message to multiple phone numbers:

```php
use Amsiam\SendSMS\Facades\SendSMS;

$phones = ['8801234567890', '8809876543210'];
$response = SendSMS::sendOneMessageToMany($phones, 'Hello, this is a broadcast message!');
```

### Sending Multiple Messages to Multiple Recipients
Send different messages to different phone numbers:

```php
use Amsiam\SendSMS\Facades\SendSMS;

$phones = ['8801234567890', '8809876543210'];
$messages = ['Hello John!', 'Hello Jane!'];
$response = SendSMS::sendManyMessageToMany($phones, $messages);
```

### Checking SMS Balance
Retrieve the balance for the configured SMS driver:

```php
use Amsiam\SendSMS\Facades\SendSMS;

$balance = SendSMS::getBalance();
```

### Static Method Calls
The `SendSMS` facade supports static method calls, making it convenient to use without manual instantiation:

```php
use Amsiam\SendSMS\Facades\SendSMS;

$response = SendSMS::sendSMS('8801234567890', 'Hello, this is a test message!');
$balance = SendSMS::getBalance();
```

**Note**: The facade internally handles instantiation and uses the default driver.

---

## Supported Drivers
The package currently supports the following driver:
- **BulkSMSBD**: A driver for the BulkSMSBD service (`Amsiam\SendSMS\Drivers\BulkSMSBDDriver`).

To add support for additional drivers, implement the `ISendSMSDriver` interface and register the driver in the configuration.

---

## Error Handling
- If the driver is not set or improperly configured, methods like `sendSMS`, `sendOneMessageToMany`, `sendManyMessageToMany`, and `getBalance` will return `null`.
- Static calls to undefined methods will throw a `BadMethodCallException`.
- Ensure the phone numbers and messages are valid for the driver being used (e.g., correct format for BulkSMSBD).

Example of handling errors:

```php
use Amsiam\SendSMS\Facades\SendSMS;

try {
    $response = SendSMS::sendSMS('8801234567890', 'Test message');
    if ($response === null) {
        // Handle driver not set or failed request
        echo "Failed to send SMS.";
    } else {
        // Handle success
        echo "SMS sent successfully!";
    }
} catch (\Exception $e) {
    // Handle exceptions (e.g., network issues, invalid configuration)
    echo "Error: " . $e->getMessage();
}
```

---

## Support
For issues or feature requests, please contact the package maintainer or open an issue on the package's GitHub repository (if available). Ensure you provide:
- Laravel version
- PHP version
- Package version
- Relevant error messages or logs

For driver-specific issues (e.g., BulkSMSBD), contact the SMS provider's support team.
