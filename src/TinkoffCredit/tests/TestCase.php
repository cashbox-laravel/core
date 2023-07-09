<?php

namespace Tests;

use CashierProvider\Core\Config\Driver as DriverConfig;
use CashierProvider\Core\Constants\Driver as DriverConstant;
use CashierProvider\Core\Facades\Config\Payment as PaymentConfig;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Tinkoff\Credit\Driver;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Cashier\Resources\Details;
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

    public const PAYMENT_EXTERNAL_ID = '456789';

    public const PAYMENT_ID = '1234567890';

    public const PAYMENT_SUM = 6000.34;

    public const PAYMENT_SUM_FORMATTED = 600034;

    public const CURRENCY = 643;

    public const CURRENCY_FORMATTED = '643';

    public const PAYMENT_DATE = '2021-07-23 17:33:27';

    public const PAYMENT_DATE_FORMATTED = '2021-07-23T17:33:27Z';

    public const STATUS = 'NEW';

    public const URL = 'https://example.com';

    public const MODEL_TYPE_ID = 123;

    public const MODEL_STATUS_ID = 0;

    public const USER_FIRST_NAME = 'John';

    public const USER_MIDDLE_NAME = 'Michael';

    public const USER_LAST_NAME = 'Doe';

    public const USER_PHONE = '+79123456789';

    public const USER_EMAIL = 'john@example.com';

    public const ORDER_ITEM_TITLE = 'Item Name';

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
            self::MODEL_TYPE_ID => 'tinkoff_credit',
        ]);

        $config->set('cashier.drivers.tinkoff_credit', [
            DriverConstant::DRIVER  => Driver::class,
            DriverConstant::DETAILS => Model::class,

            DriverConstant::CLIENT_ID     => env('CASHIER_TINKOFF_CREDIT_CLIENT_ID'),
            DriverConstant::CLIENT_SECRET => env('CASHIER_TINKOFF_CREDIT_PASSWORD'),

            'show_case_id' => env('CASHIER_TINKOFF_CREDIT_SHOW_CASE_ID'),

            'promocode' => env('CASHIER_TINKOFF_CREDIT_PROMOCODE'),
        ]);
    }

    protected function model(?Details $details = null): ReadyPayment
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
     * @param \CashierProvider\Tinkoff\Credit\Requests\BaseRequest|string $request
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
        $config = config('cashier.drivers.tinkoff_credit');

        return DriverConfig::make($config);
    }

    protected function getClientId(): string
    {
        return config('cashier.drivers.tinkoff_credit.client_id');
    }

    protected function getShowCaseId(): string
    {
        return config('cashier.drivers.tinkoff_credit.show_case_id');
    }

    protected function getPromoCode(): string
    {
        return config('cashier.drivers.tinkoff_credit.promocode');
    }
}
