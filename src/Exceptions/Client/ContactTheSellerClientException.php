<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Exceptions\Client;

class ContactTheSellerClientException extends BaseClientException
{
    protected $status_code = 409;

    protected $reason = 'Contact The Seller';
}
