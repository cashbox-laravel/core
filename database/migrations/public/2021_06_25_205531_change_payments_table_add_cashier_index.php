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

use Helldar\Cashier\Facades\Config\Payment;
use Helldar\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePaymentsTableAddCashierIndex extends Migration
{
    use InitModelHelper;

    /**
     * @throws \Helldar\LaravelSupport\Exceptions\IncorrectModelException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function up()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->index($this->fields());
        });
    }

    /**
     * @throws \Helldar\LaravelSupport\Exceptions\IncorrectModelException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function down()
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->dropIndex($this->fields());
        });
    }

    protected function fields(): array
    {
        return [
            $this->attributeType(),
            $this->attributeStatus(),
            $this->attributeCreatedAt(),
        ];
    }

    /**
     * @throws \Helldar\LaravelSupport\Exceptions\IncorrectModelException
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
