<?php

namespace Helldar\Cashier\Jobs;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\DTO\Response;

final class Refund extends Base
{
    public function handle()
    {
        $response = $this->process();

        $status = $response->getStatus();

        if ($this->hasRefunding($status)) {
            $this->returnToQueue();

            return;
        }

        $this->setParentStatus(Status::REFUND);

        $this->store($response);
    }

    protected function process(): Response
    {
        return $this->driver()->refund();
    }
}
