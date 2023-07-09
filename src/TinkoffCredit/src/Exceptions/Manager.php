<?php

namespace CashierProvider\Tinkoff\Credit\Exceptions;

use CashierProvider\Core\Exceptions\Http\BankInternalErrorException;
use CashierProvider\Core\Exceptions\Http\BuyerNotFoundClientException;
use CashierProvider\Core\Exceptions\Http\CardHasStolenException;
use CashierProvider\Core\Exceptions\Http\ContactTheSellerClientException;
use CashierProvider\Core\Exceptions\Http\InsufficientFundsCardException;
use CashierProvider\Core\Exceptions\Http\InvalidCardException;
use CashierProvider\Core\Exceptions\Http\PaymentCompletedException;
use CashierProvider\Core\Exceptions\Http\PaymentDeclinedException;
use CashierProvider\Core\Exceptions\Http\PaymentTypeNotAvailableException;
use CashierProvider\Core\Exceptions\Http\SumException;
use CashierProvider\Core\Exceptions\Http\TooManyRequestsException;
use CashierProvider\Core\Exceptions\Http\TryAgainLaterClientException;
use CashierProvider\Core\Exceptions\Manager as ExceptionManager;
use CashierProvider\Tinkoff\Credit\Exceptions\Http\CancelDeniedException;
use CashierProvider\Tinkoff\Credit\Exceptions\Http\NotFoundException;
use Illuminate\Support\Arr;

class Manager extends ExceptionManager
{
    protected $codes = [
        7    => BuyerNotFoundClientException::class,
        53   => ContactTheSellerClientException::class,
        99   => PaymentDeclinedException::class,
        100  => TryAgainLaterClientException::class,
        102  => PaymentDeclinedException::class,
        103  => TryAgainLaterClientException::class,
        119  => TooManyRequestsException::class,
        403  => CancelDeniedException::class,
        404  => NotFoundException::class,
        604  => PaymentDeclinedException::class,
        620  => SumException::class,
        623  => PaymentCompletedException::class,
        642  => InvalidCardException::class,
        1004 => CardHasStolenException::class,
        1005 => PaymentDeclinedException::class,
        1007 => CardHasStolenException::class,
        1008 => PaymentDeclinedException::class,
        1012 => PaymentDeclinedException::class,
        1013 => TryAgainLaterClientException::class,
        1014 => InvalidCardException::class,
        1015 => TryAgainLaterClientException::class,
        1019 => PaymentDeclinedException::class,
        1030 => TryAgainLaterClientException::class,
        1033 => InvalidCardException::class,
        1034 => TryAgainLaterClientException::class,
        1039 => PaymentDeclinedException::class,
        1041 => CardHasStolenException::class,
        1043 => CardHasStolenException::class,
        1051 => InsufficientFundsCardException::class,
        1053 => PaymentDeclinedException::class,
        1054 => InvalidCardException::class,
        1057 => InvalidCardException::class,
        1058 => InvalidCardException::class,
        1059 => CardHasStolenException::class,
        1061 => InvalidCardException::class,
        1062 => InvalidCardException::class,
        1063 => InvalidCardException::class,
        1064 => SumException::class,
        1065 => PaymentDeclinedException::class,
        1076 => PaymentDeclinedException::class,
        1089 => TryAgainLaterClientException::class,
        1091 => TryAgainLaterClientException::class,
        1092 => PaymentDeclinedException::class,
        1093 => CardHasStolenException::class,
        1094 => BankInternalErrorException::class,
        1096 => TryAgainLaterClientException::class,
        3001 => PaymentTypeNotAvailableException::class,
        9999 => BankInternalErrorException::class,
    ];

    protected $reason_keys = ['Message', 'Data', 'errors'];

    protected function getReason(array $response): ?string
    {
        foreach ($this->reason_keys as $key) {
            if ($value = Arr::get($response, $key)) {
                if (is_string($value)) {
                    return $value;
                }

                if (is_array($value)) {
                    return Arr::first($value);
                }
            }
        }

        return ! empty($response) ? Arr::first($response) : null;
    }
}
