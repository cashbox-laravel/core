<?php

declare(strict_types=1);

namespace Helldar\Cashier\Config;

use Helldar\Contracts\Cashier\Config\Http as HttpContract;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Http extends DataTransferObject implements HttpContract
{
    protected $ssl_verify;

    /**
     * @return bool|string
     */
    public function sslVerify()
    {
        return $this->ssl_verify;
    }
}
