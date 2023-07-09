<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Services;

use CashierProvider\Core\Concerns\Resolvable;
use CashierProvider\Core\Concerns\Validators;
use CashierProvider\Core\Facades\Helpers\Http;
use DragonCode\Contracts\Cashier\Config\Driver as DriverConfig;
use DragonCode\Contracts\Cashier\Config\Queues\Names;
use DragonCode\Contracts\Cashier\Driver as Contract;
use DragonCode\Contracts\Cashier\Helpers\Statuses;
use DragonCode\Contracts\Cashier\Http\Request as RequestResource;
use DragonCode\Contracts\Cashier\Http\Response;
use DragonCode\Contracts\Cashier\Resources\Details;
use DragonCode\Contracts\Cashier\Resources\Model as ModelResource;
use DragonCode\Contracts\Exceptions\Manager as ExceptionManager;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;

abstract class Driver implements Contract
{
    use Makeable;
    use Resolvable;
    use Validators;

    /** @var DriverConfig */
    protected $config;

    /** @var \CashierProvider\Core\Concerns\Casheable|Model */
    protected $payment;

    /** @var ModelResource */
    protected $model;

    /** @var ExceptionManager */
    protected $exceptions;

    /** @var \DragonCode\Contracts\Cashier\Helpers\Statuses|string */
    protected $statuses;

    /** @var \DragonCode\Contracts\Cashier\Resources\Details */
    protected $details;

    public function __construct(DriverConfig $config, Model $payment)
    {
        $this->config = $config;

        $this->payment = $this->validateModel($payment);

        $this->model = $this->resolveModel($payment);
    }

    public function statuses(): Statuses
    {
        return $this->resolveDynamicCallback($this->statuses, function (string $statuses) {
            // @var \DragonCode\Contracts\Cashier\Helpers\Statuses|string $statuses
            return $statuses::make($this->payment);
        });
    }

    public function details(array $details): Details
    {
        $cast = $this->details;

        return $cast::make($details);
    }

    public function queue(): Names
    {
        return $this->config->getQueue();
    }

    /**
     * @param  \DragonCode\Contracts\Cashier\Http\Response|string  $response
     */
    protected function request(RequestResource $request, string $response): Response
    {
        $manager = $this->resolveExceptionManager();

        $content = Http::request($request, $manager);

        return $response::make($content);
    }

    protected function resolveModel(Model $payment): ModelResource
    {
        $resource = $this->config->getDetails();

        return $resource::make($payment, $this->config);
    }

    protected function resolveExceptionManager(): ExceptionManager
    {
        return self::resolveInstance($this->exceptions);
    }
}
