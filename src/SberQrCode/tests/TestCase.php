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

namespace Tests;

use CashierProvider\Core\Config\Driver as DriverConfig;
use CashierProvider\Core\Constants\Driver as DriverConstant;
use CashierProvider\Core\Facades\Config\Payment as PaymentConfig;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Sber\QrCode\Driver;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Cashier\Resources\Details;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\Database;
use Tests\Concerns\TestServiceProvider;
use Tests\Fixtures\Resources\Model;

abstract class TestCase extends BaseTestCase
{
    use Database;

    public const PAYMENT_EXTERNAL_ID = '456789';

    public const PAYMENT_ID = '1234567890';

    public const PAYMENT_SUM = 12.34;

    public const PAYMENT_SUM_FORMATTED = 1234;

    public const CURRENCY = 'RUB';

    public const CURRENCY_FORMATTED = '643';

    public const PAYMENT_DATE = '2021-07-23 17:33:27';

    public const PAYMENT_DATE_FORMATTED = '2021-07-23T17:33:27Z';

    public const STATUS = 'CREATED';

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

        $config->set('cashier.env', env('CASHIER_ENV', env('APP_ENV', 'testing')));

        $config->set('cashier.payment.model', $this->model);

        $config->set('cashier.payment.map', [
            self::MODEL_TYPE_ID => 'sber_qr',
        ]);

        $is_production = $config->get('cashier.env') === 'production';

        $config->set('cashier.drivers.sber_qr', [
            DriverConstant::DRIVER  => Driver::class,
            DriverConstant::DETAILS => Model::class,

            DriverConstant::CLIENT_ID     => env('CASHIER_SBER_QR_CLIENT_ID'),
            DriverConstant::CLIENT_SECRET => env('CASHIER_SBER_QR_CLIENT_SECRET'),

            'member_id'   => env('CASHIER_SBER_QR_MEMBER_ID'),
            'terminal_id' => env('CASHIER_SBER_QR_TERMINAL_ID'),

            'certificate_path' => $is_production ? realpath(__DIR__ . '/../sber.pem') : null,

            'certificate_password' => $is_production ? env('CASHIER_SBER_QR_CERTIFICATE_PASSWORD') : null,
        ]);
    }

    protected function model(Details $details = null, int $status_id = 0): EloquentModel
    {
        $model = PaymentConfig::getModel();

        /** @var \Illuminate\Database\Eloquent\Model $payment */
        $payment = new $model();

        $cashier = $this->detailsRelation($payment, $details);

        return $payment
            ->setRelation('cashier', $cashier)
            ->setAttribute('status_id', $status_id);
    }

    protected function detailsRelation(EloquentModel $model, ?Details $details): CashierDetail
    {
        $details = new CashierDetail([
            'item_type' => get_class($model),

            'item_id'     => self::PAYMENT_ID,
            'external_id' => self::PAYMENT_EXTERNAL_ID,

            'details' => $details,
        ]);

        return $details->setRelation('parent', $model);
    }

    /**
     * @param  \CashierProvider\Sber\QrCode\Requests\BaseRequest|string  $request
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
        $config = config('cashier.drivers.sber_qr');

        return DriverConfig::make($config);
    }

    protected function getClientId(): string
    {
        return config('cashier.drivers.sber_qr.client_id');
    }

    protected function getClientSecret(): string
    {
        return config('cashier.drivers.sber_qr.client_secret');
    }
}
