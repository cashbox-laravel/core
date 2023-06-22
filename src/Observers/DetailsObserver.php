<?php

/**
 * This file is part of the "cashier-provider/core" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider
 */

declare(strict_types=1);

namespace CashierProvider\Core\Observers;

use CashierProvider\Core\Enums\Status;
use CashierProvider\Core\Facades\Config;
use CashierProvider\Core\Models\CashierDetail;
use CashierProvider\Core\Services\Job;

class DetailsObserver extends BaseObserver
{
    public function saved(CashierDetail $model): void
    {
        if ($model->isClean()) {
            return;
        }

        $statuses = $model->parent->cashierDriver()->statuses();

        $status = $model->details->status;

        if ($model->isDirty('details')) {
            match (true) {
                $statuses->hasSuccess($status) => $this->updateStatus($model, Status::success),
                $statuses->hasRefunded($status) => $this->updateStatus($model, Status::refund),
                $statuses->hasFailed($status) => $this->updateStatus($model, Status::failed),
            };
        }

        Job::make($model->parent)->check();
    }

    protected function updateStatus(CashierDetail $model, Status $status): void
    {
        $value = $this->status($status);
        $field = $this->attributeStatus();

        $model->parent->update([$field => $value]);
    }

    protected function status(Status $status): mixed
    {
        return Config::payment()->status->get($status);
    }
}
