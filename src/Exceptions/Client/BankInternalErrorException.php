<?php

namespace Helldar\Cashier\Exceptions\Client;

class BankInternalErrorException extends BaseClientException
{
    protected $status_code = 400;

    protected $reason = 'Internal error of the bank system';
}
