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

namespace Helldar\Cashier\Observers;

use Helldar\Cashier\Facades\Helpers\Access;
use Helldar\Cashier\Services\Jobs;
use Illuminate\Database\Eloquent\Model;

class PaymentsObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    public function saved(Model $model)
    {
        if ($this->allow($model)) {
            $this->jobs($model)->start();
            $this->jobs($model)->check();
        }
    }

    /**
     * @param  \Helldar\Cashier\Concerns\Casheable|\Illuminate\Database\Eloquent\Model  $model
     */
    public function deleted(Model $model)
    {
        $model->cashier()->delete();
    }

    protected function allow(Model $model): bool
    {
        return Access::allow($model);
    }

    protected function jobs(Model $model): Jobs
    {
        return Jobs::make($model);
    }
}
