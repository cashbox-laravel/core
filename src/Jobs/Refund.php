<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Jobs;

use Helldar\Cashier\Constants\Status;
use Helldar\Contracts\Cashier\Resources\Response;

class Refund extends Base
{
    public function handle()
    {
        $response = $this->process();

        $status = $response->getStatus();

        if ($this->hasRefunding($status)) {
            $this->returnToQueue();

            return;
        }

        $this->updateParentStatus(Status::REFUND);

        $this->store($response);
    }

    protected function process(): Response
    {
        return $this->driver()->refund();
    }
}
