<?php

/*
 * This file is part of the "cashier-provider/sber-auth" project.
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
 * @see https://github.com/cashier-provider/sber-auth
 */

namespace Tests;

use CashierProvider\Core\Config\Driver;
use CashierProvider\Core\Constants\Driver as DriverConstant;
use CashierProvider\Sber\Auth\Constants\Keys;
use DragonCode\Contracts\Cashier\Config\Driver as DriverContract;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Cashier\Resources\Model;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Fixtures\ModelEloquent;
use Tests\Fixtures\ModelResource;

abstract class TestCase extends BaseTestCase
{
    public const PAYMENT_ID = '123456';

    public const SUM = 123.45;

    public const SUM_RESULT = 12345;

    public const CURRENCY = 'RUB';

    public const CURRENCY_RESULT = '643';

    public const CREATED_AT = '2021-07-29 18:51:03';

    public const CREATED_AT_RESULT = '2021-07-29T18:51:03Z';

    public const SCOPE_CREATE = 'https://api.sberbank.ru/order.create';

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('cache:clear')->run();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__ . '/../');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('cashier.logs.enabled', false);

        $config->set('cashier.drivers.sber_qr', [
            DriverConstant::CLIENT_ID     => env('CASHIER_SBER_QR_CLIENT_ID'),
            DriverConstant::CLIENT_SECRET => env('CASHIER_SBER_QR_CLIENT_SECRET'),

            'member_id' => env('CASHIER_SBER_QR_MEMBER_ID'),
        ]);
    }

    protected function credentials(): array
    {
        return $this->auth($this->clientId(), $this->clientSecret());
    }

    protected function auth(string $client_id, string $client_secret): array
    {
        return [
            Keys::CLIENT_ID => $client_id,
            Keys::TOKEN     => $client_secret,
        ];
    }

    protected function model(): Model
    {
        $eloquent = new ModelEloquent();

        $config = $this->config();

        return new ModelResource($eloquent, $config);
    }

    protected function config(): DriverContract
    {
        return Driver::make(config('cashier.drivers.sber_qr'));
    }

    protected function request(): Request
    {
        return Fixtures\Request::make($this->model());
    }

    protected function clientId(): string
    {
        return config('cashier.drivers.sber_qr.client_id');
    }

    protected function clientSecret(): string
    {
        return config('cashier.drivers.sber_qr.client_secret');
    }
}
