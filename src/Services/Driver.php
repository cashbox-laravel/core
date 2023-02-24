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

use CashierProvider\Core\Concerns\Validators;
use CashierProvider\Core\Data\Config\Driver as DriverConfig;
use CashierProvider\Core\Data\Config\QueueName;
use CashierProvider\Core\Exceptions\Manager;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Helpers\Http;
use CashierProvider\Core\Resources\Model as ResourceModel;
use DragonCode\Contracts\Cashier\Http\Request as RequestResource;
use DragonCode\Contracts\Cashier\Http\Response;
use DragonCode\Contracts\Cashier\Resources\Details;
use DragonCode\Contracts\Exceptions\Manager as ExceptionManager;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Concerns\Resolvable;
use Illuminate\Database\Eloquent\Model;

abstract class Driver
{
    use Makeable;
    use Resolvable;
    use Validators;

    protected ResourceModel $model;

    protected ExceptionManager $exceptions;

    protected Statuses|string $statuses;

    protected Details $details;

    public function __construct(
        protected DriverConfig $config,
        protected Model        $payment,
        protected Http         $client
    ) {
        $this->payment = $this->validateModel($payment);
        $this->model   = $this->resolveModel($payment);
    }

    abstract public function check(): Response;

    abstract public function refund(): Response;

    abstract public function start(): Response;

    public function statuses(): Statuses
    {
        return $this->resolveCallback($this->statuses, function (string $statuses) {
            return $statuses::make($this->payment);
        });
    }

    public function details(array $details): Details
    {
        $cast = $this->details;

        return $cast::make($details);
    }

    public function queue(): QueueName
    {
        return $this->config?->queue ?? Config::queue()->names;
    }

    protected function request(RequestResource $request, \CashierProvider\Core\Http\Response|string $response): Response
    {
        $manager = $this->resolveExceptionManager();

        return $response::make($this->client->request($request, $manager));
    }

    protected function resolveModel(Model $payment): ResourceModel
    {
        $resource = $this->config->details;

        return $resource::make($payment, $this->config);
    }

    protected function resolveExceptionManager(): Manager
    {
        return self::resolveInstance($this->exceptions);
    }
}
