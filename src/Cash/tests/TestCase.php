<?php

/*
 * This file is part of the "cashier-provider/cash" project.
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
 * @see https://github.com/cashier-provider/cash
 */

namespace Tests;

use CashierProvider\Cash\Driver;
use CashierProvider\Core\Config\Driver as DriverConfig;
use CashierProvider\Core\Constants\Driver as DriverConstant;
use CashierProvider\Core\Facades\Config\Payment as PaymentConfig;
use CashierProvider\Core\Models\CashierDetail;
use Helldar\Contracts\Cashier\Http\Request;
use Helldar\Contracts\Cashier\Resources\Details;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Database;
use Tests\Concerns\TestServiceProvider;
use Tests\Fixtures\Models\ReadyPayment;
use Tests\Fixtures\Resources\Model;

abstract class TestCase extends BaseTestCase
{
    use Database;

    public const PAYMENT_EXTERNAL_ID = '1234567890';

    public const PAYMENT_ID = '1234567890';

    public const PAYMENT_SUM = 12.34;

    public const PAYMENT_SUM_FORMATTED = 1234;

    public const CURRENCY = 643;

    public const CURRENCY_FORMATTED = '643';

    public const PAYMENT_DATE = '2021-07-23 17:33:27';

    public const PAYMENT_DATE_FORMATTED = '2021-07-23T17:33:27Z';

    public const STATUS = 'PAID';

    public const URL = 'https://example.com';

    public const MODEL_TYPE_ID = 123;

    public const MODEL_STATUS_ID = 0;

    protected function getPackageProviders($app): array
    {
        return [TestServiceProvider::class];
    }

    protected function getEnvironmentSetup($app)
    {
        $app->useEnvironmentPath(__DIR__ . '/../');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('cashier.payment.model', $this->model);

        $config->set('cashier.payment.map', [
            self::MODEL_TYPE_ID => 'cash',
        ]);

        $config->set('cashier.drivers.cash', [
            DriverConstant::DRIVER  => Driver::class,
            DriverConstant::DETAILS => Model::class,
        ]);
    }

    protected function model(Details $details = null): ReadyPayment
    {
        $model = PaymentConfig::getModel();

        $payment = new $model();

        $cashier = $this->detailsRelation($payment, $details);

        return $payment->setRelation('cashier', $cashier);
    }

    protected function detailsRelation(EloquentModel $model, ?Details $details): CashierDetail
    {
        $details = new CashierDetail([
            'item_type' => ReadyPayment::class,

            'item_id'     => self::PAYMENT_ID,
            'external_id' => self::PAYMENT_EXTERNAL_ID,

            'details' => $details,
        ]);

        return $details->setRelation('parent', $model);
    }

    /**
     * @param  \CashierProvider\Cash\Requests\BaseRequest|string  $request
     *
     * @return \Helldar\Contracts\Cashier\Http\Request
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
        $config = config('cashier.drivers.cash');

        return DriverConfig::make($config);
    }
}
