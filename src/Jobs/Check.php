<?php

declare(strict_types = 1);

namespace Helldar\Cashier\Jobs;

use Helldar\Cashier\Constants\Status;
use Helldar\Contracts\Cashier\Resources\Response;

class Check extends Base
{
    public function handle()
    {
        $response = $this->process();

        $status = $response->getStatus();

        switch (true) {
            case $this->hasFailed($status):
                $this->update($response, Status::FAILED);
                break;

            case $this->hasRefunding($status):
                $this->update($response, Status::WAIT_REFUND);
                break;

            case $this->hasRefunded($status):
                $this->update($response, Status::REFUND);
                break;

            case $this->hasSuccess($status):
                $this->update($response, Status::SUCCESS);
                break;

            default:
                if ($this->hasBreak()) {
                    return;
                }

                $this->returnToQueue();
        }
    }

    protected function process(): Response
    {
        return $this->driver()->check();
    }

    protected function update(Response $response, string $status): void
    {
        $this->updateParentStatus($status);
        $this->store($response);
    }
}
