<?php

/*
 * This file is part of the "cashier-provider/core" project.
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
 * @see https://github.com/cashier-provider/core
 */

declare(strict_types=1);

namespace CashierProvider\Core\Models;

use CashierProvider\Core\Concerns\Relations;
use CashierProvider\Core\Facades\Config\Details;
use CashierProvider\Core\Facades\Helpers\DriverManager;
use CashierProvider\Core\Facades\Helpers\JSON;
use DragonCode\Contracts\Cashier\Resources\Details as DetailsCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property \DragonCode\Contracts\Cashier\Resources\Details $details
 * @property \Illuminate\Database\Eloquent\Model $parent
 * @property array|null $extra
 * @property string $external_id
 * @property string $item_type
 * @property string $operation_id
 * @property int|string $item_id
 */
class CashierDetail extends Model
{
    use Relations;

    protected $fillable = ['item_type', 'item_id', 'external_id', 'operation_id', 'details'];

    protected $touches = ['parent'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(Details::getTable());

        parent::__construct($attributes);
    }

    public function parent(): MorphTo
    {
        return $this->morphTo('item');
    }

    protected function setDetailsAttribute(?DetailsCast $details = null): void
    {
        $this->attributes['details'] = $details ? $details->toJson() : null;
    }

    protected function getDetailsAttribute(): ?DetailsCast
    {
        $this->resolvePayment($this);

        $decoded = JSON::decode($this->attributes['details']);

        return DriverManager::fromModel($this->parent)->details($decoded);
    }
}
