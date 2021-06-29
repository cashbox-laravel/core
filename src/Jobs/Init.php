<?php

namespace Helldar\Cashier\Jobs;

use Helldar\Cashier\Resources\Response;

final class Init extends Base
{
    public function handle()
    {
        $data = $this->process();

        $this->store($data);
    }

    protected function process(): Response
    {
        return $this->driver()->init();
    }
}
