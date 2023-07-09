<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
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
 * @see https://github.com/cashier-provider/tinkoff-online
 */

namespace Tests;

use CashierProvider\Core\Config\Driver as DriverConfig;
use CashierProvider\Core\Constants\Driver as DriverConstant;
use CashierProvider\Core\Facades\Config\Payment as PaymentConfig;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Providers\ServiceProvider;
use CashierProvider\Tinkoff\Online\Driver;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Cashier\Resources\Details;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\database\seeders\DatabaseSeeder;
use Tests\Fixtures\Models\ReadyPayment;
use Tests\Fixtures\Resources\Model;

abstract class TestCase extends BaseTestCase
{
    public const PAYMENT_EXTERNAL_ID = '456789';

    public const PAYMENT_ID = '1234567890';

    public const PAYMENT_SUM = 12.34;

    public const PAYMENT_SUM_FORMATTED = 1234;

    public const CURRENCY = 643;

    public const CURRENCY_FORMATTED = '643';

    public const PAYMENT_DATE = '2021-07-23 17:33:27';

    public const PAYMENT_DATE_FORMATTED = '2021-07-23T17:33:27Z';

    public const STATUS = 'NEW';

    public const URL = 'https://example.com';

    public const MODEL_TYPE_ID = 123;

    public const MODEL_STATUS_ID = 0;

    protected $loadEnvironmentVariables = true;

    protected $model = ReadyPayment::class;

    protected function getPackageProviders($app): array
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetup($app)
    {
        $app->useEnvironmentPath(__DIR__ . '/../');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('cashier.payment.model', $this->model);

        $config->set('cashier.payment.map', [
            self::MODEL_TYPE_ID => 'tinkoff_online',
        ]);

        $config->set('cashier.logs.enabled', false);

        $config->set('cashier.drivers.tinkoff_online', [
            DriverConstant::DRIVER  => Driver::class,
            DriverConstant::DETAILS => Model::class,

            DriverConstant::CLIENT_ID     => env('CASHIER_TINKOFF_CLIENT_ID'),
            DriverConstant::CLIENT_SECRET => env('CASHIER_TINKOFF_CLIENT_SECRET'),
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/cashier-provider/core/database/migrations/main');
    }

    protected function model(?Details $details = null): ReadyPayment
    {
        $model = PaymentConfig::getModel();

        $payment = new $model();

        return $payment->setRelation('cashier', $this->detailsRelation($payment, $details));
    }

    protected function detailsRelation(EloquentModel $model, ?Details $details): CashierDetail
    {
        $details = new CashierDetail([
            'item_type'   => ReadyPayment::class,
            'item_id'     => self::PAYMENT_ID,
            'external_id' => self::PAYMENT_EXTERNAL_ID,
            'details'     => $details,
        ]);

        return $details->setRelation('parent', $model);
    }

    /**
     * @param \CashierProvider\Tinkoff\Online\Requests\BaseRequest|string $request
     *
     * @return \DragonCode\Contracts\Cashier\Http\Request
     */
    protected function request(string $request): Request
    {
        $model = $this->modelRequest();

        return $request::make($model);
    }

    protected function modelRequest(): Model
    {
        return Model::make($this->model(), $this->config());
    }

    protected function config(): DriverConfig
    {
        $config = config('cashier.drivers.tinkoff_online');

        return DriverConfig::make($config);
    }

    protected function getTerminalKey(): string
    {
        return config('cashier.drivers.tinkoff_online.client_id');
    }

    protected function getTerminalSecret(): string
    {
        return config('cashier.drivers.tinkoff_online.client_secret');
    }

    protected function runSeeders()
    {
        $seeder = new DatabaseSeeder();

        $seeder->run();
    }
}
