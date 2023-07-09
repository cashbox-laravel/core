<?php

/*
 * This file is part of the "cashier-provider/sber-auth" project.
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
 * @see https://github.com/cashier-provider/sber-auth
 */

declare(strict_types=1);

namespace CashierProvider\Sber\Auth\Objects;

use DragonCode\Contracts\Cashier\Resources\Model;
use DragonCode\SimpleDataTransferObject\DataTransferObject;

class Query extends DataTransferObject
{
    protected $model;

    protected $scope;

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getScope(): string
    {
        return $this->scope;
    }
}
