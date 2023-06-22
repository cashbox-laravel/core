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

namespace CashierProvider\Core\Jobs;

use CashierProvider\Core\Events\Processes\StartedEvent;
use CashierProvider\Core\Http\Response;

class Start extends Base
{
    protected string $event = StartedEvent::class;

    public function handle(): void
    {
        $this->call(function () {
            $data = $this->process();

            $this->store($data);
        });
    }

    protected function process(): Response
    {
        return $this->resolveDriver()->start();
    }

    protected function queueName(): ?string
    {
        return $this->resolveDriver()->queue()->start;
    }
}
