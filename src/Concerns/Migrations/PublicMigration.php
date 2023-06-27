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

namespace CashierProvider\Core\Concerns\Migrations;

use CashierProvider\Core\Facades\Config\Payment;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Migrations\Migration;

abstract class PublicMigration extends Migration
{
    use InitModelHelper;

    /**
     * @throws \DragonCode\LaravelSupport\Exceptions\IncorrectModelException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function table(): string
    {
        $model = $this->getModel();

        return $this->model()->table($model);
    }

    protected function attributeType(): string
    {
        return Payment::getAttributes()->getType();
    }

    protected function attributeStatus(): string
    {
        return Payment::getAttributes()->getStatus();
    }

    protected function attributeCreatedAt(): string
    {
        return Payment::getAttributes()->getCreatedAt();
    }

    protected function getModel(): string
    {
        return Payment::getModel();
    }
}
