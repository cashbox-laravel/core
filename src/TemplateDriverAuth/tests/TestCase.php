<?php

namespace Tests;

use Helldar\Cashier\Config\Driver;
use Helldar\Cashier\Constants\Driver as DriverConstant;
use Helldar\Contracts\Cashier\Config\Driver as DriverCotract;
use Helldar\Contracts\Cashier\Http\Request;
use Helldar\Contracts\Cashier\Resources\Model;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\ModelEloquent;
use Tests\Fixtures\ModelResource;

abstract class TestCase extends BaseTestCase
{
    public const TERMINAL_KEY = '1234567890';

    public const TOKEN = '5szqkybmwvjcgcb7';

    public const TOKEN_HASH = '16237a729273fbf1b5224906a40ea601664660b77aabcdaecab505b16ed0f545';

    public const PAYMENT_ID = '123456';

    public const SUM = 123.45;

    public const SUM_RESULT = 12345;

    public const CURRENCY = 'RUB';

    public const CURRENCY_RESULT = '643';

    public const CREATED_AT = '2021-07-29 18:51:03';

    public const CREATED_AT_RESULT = '2021-07-29T18:51:03Z';

    protected function credentials(): array
    {
        return $this->auth(self::TERMINAL_KEY, self::TOKEN);
    }

    protected function credentialsHash(): array
    {
        return $this->auth(self::TERMINAL_KEY, self::TOKEN_HASH);
    }

    protected function auth(string $terminal, string $secret): array
    {
        return [
            'TerminalKey' => $terminal,
            'Token'       => $secret,
        ];
    }

    protected function model(): Model
    {
        $eloquent = new ModelEloquent();

        $config = $this->config();

        return new ModelResource($eloquent, $config);
    }

    protected function config(): DriverCotract
    {
        return Driver::make([
            DriverConstant::CLIENT_ID => self::TERMINAL_KEY,

            DriverConstant::CLIENT_SECRET => self::TOKEN,
        ]);
    }

    protected function request(): Request
    {
        return Fixtures\Request::make($this->model());
    }
}
