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
use CashierProvider\Core\Data\Config\DriverData as DriverConfig;
use CashierProvider\Core\Data\Config\Queue\QueueNameData;
use CashierProvider\Core\Exceptions\Manager;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Helpers\Http;
use CashierProvider\Core\Http\Request;
use CashierProvider\Core\Http\Response;
use CashierProvider\Core\Resources\Details;
use CashierProvider\Core\Resources\Model as ResourceModel;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Concerns\Resolvable;
use Illuminate\Database\Eloquent\Model;

abstract class Driver
{
    use Makeable;
    use Resolvable;
    use Validators;

    protected ResourceModel $model;

    protected Manager $exceptions;

    protected Statuses|string $statuses;

    protected Details $details;

    abstract public function check(): Response;

    abstract public function refund(): Response;

    abstract public function start(): Response;

    public function __construct(
        protected DriverConfig $config,
        protected Model $payment,
        protected Http $client
    ) {
        $this->payment = $this->validateModel($payment);
        $this->model   = $this->resolveModel($payment);
    }

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

    public function queue(): QueueNameData
    {
        return $this->config?->queue ?? Config::queue()->name;
    }

    protected function request(Request $request, Response|string $response): Response
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
