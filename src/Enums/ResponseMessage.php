<?php

namespace Amsiam\SendSMS\Enums;

enum ResponseMessage: string
{
    case SMS_SENT = 'success';
    case INVALID_SENDER = 'invalid_sender';
    case MISSING_FIELDS = 'missing_fields';
    case SERVER_ERROR = 'server_error';
    case NO_VALIDITY = 'no_validity';
    case LOW_BALANCE = 'low_balance';
    case USER_NOT_FOUND = 'no_user_found';
    case BENGALI_REQUIRED = 'bengali_required';
    case NO_GATEWAY = 'no_gateway';
    case SENDER_TYPE_NOT_FOUND = 'no_sender_type_found';
    case NO_VALID_GATEWAY = 'no_valid_gateway';
    case NO_ACTIVE_PRICE = 'no_active_price';
    case NO_PRICE_INFO = 'no_price_info';
    case ACCOUNT_DISABLED = 'account_disabled';
    case PRICE_DISABLED = 'price_disabled';
    case PARENT_NOT_FOUND = 'parent_not_found';
    case NO_PARENT_PRICE = 'no_parent_price';
    case UNKNOWN_ERROR = 'unknown_error';

    public function message(): string
    {
        return match ($this) {
            self::SMS_SENT => 'Success',
            self::INVALID_SENDER => 'sender id not correct/sender id is disabled',
            self::MISSING_FIELDS => 'Please Required all fields/Contact Your System Administrator',
            self::SERVER_ERROR => 'Internal Error',
            self::NO_VALIDITY => 'Balance Validity Not Available',
            self::LOW_BALANCE => 'Balance Insufficient',
            self::USER_NOT_FOUND => 'User Id not found',
            self::BENGALI_REQUIRED => 'Masking SMS must be sent in Bengali',
            self::NO_GATEWAY => 'Sender Id has not found Gateway by api key',
            self::SENDER_TYPE_NOT_FOUND => 'Sender Type Name not found using this sender by api key',
            self::NO_VALID_GATEWAY => 'Sender Id has not found Any Valid Gateway by api key',
            self::NO_ACTIVE_PRICE => 'Sender Type Name Active Price Info not found by this sender id',
            self::NO_PRICE_INFO => 'Sender Type Name Price Info not found by this sender id',
            self::ACCOUNT_DISABLED => 'The Owner of this (username) Account is disabled',
            self::PRICE_DISABLED => 'The (sender type name) Price of this (username) Account is disabled',
            self::PARENT_NOT_FOUND => 'The parent of this account is not found.',
            self::NO_PARENT_PRICE => 'The parent active (sender type name) price of this account is not found.',
        };
    }
}
