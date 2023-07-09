<?php

/*
 * This file is part of the "cashier-provider/sber-qr" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/sber-qr
 */

namespace CashierProvider\Sber\QrCode\Exceptions;

use CashierProvider\Core\Exceptions\Http\BadRequestClientException;
use CashierProvider\Core\Exceptions\Http\BankInternalErrorException;
use CashierProvider\Core\Exceptions\Http\MethodNotFoundException;
use CashierProvider\Core\Exceptions\Http\TooManyRequestsException;
use CashierProvider\Core\Exceptions\Http\UnauthorizedException;
use CashierProvider\Core\Exceptions\Manager as ExceptionManager;

class Manager extends ExceptionManager
{
    protected $codes = [
        400 => BadRequestClientException::class,
        401 => UnauthorizedException::class,
        405 => MethodNotFoundException::class,
        429 => TooManyRequestsException::class,

        500 => BankInternalErrorException::class,
        503 => BankInternalErrorException::class,
    ];

    protected $code_keys = ['httpCode', 'status.error_code'];

    protected $success_keys = [];

    protected $reason_keys = ['moreInformation', 'httpMessage', 'Message', 'status.error_description'];

    protected function isFailedContentCode(array $response): bool
    {
        $code = $this->getCodeByResponseContent($response);

        return ! is_null($code) && $code !== 0;
    }
}
