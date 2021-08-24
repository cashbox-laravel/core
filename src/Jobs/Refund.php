<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
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
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Jobs;

use Helldar\Cashier\Constants\Status;
use Helldar\Cashier\Exceptions\Logic\UnknownExternalIdException;
use Helldar\Contracts\Cashier\Http\Response;

class Refund extends Base
{
    public function handle()
    {
        if (empty($this->model->cashier->external_id)) {
            throw new UnknownExternalIdException($this->paymentId());
        }

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

    protected function paymentId()
    {
        return $this->model->getKey();
    }
}
