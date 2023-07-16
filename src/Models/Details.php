<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Core\Models;

use Cashbox\Core\Billable;
use Cashbox\Core\Concerns\Config\Details as DetailsConcern;
use Cashbox\Core\Data\Models\InfoData;
use Cashbox\Core\Enums\StatusEnum;
use Cashbox\Core\Facades\Config;
use DragonCode\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property InfoData $info
 * @property StatusEnum $status
 * @property Model|Billable $parent
 */
class Details extends Model
{
    use DetailsConcern;
    use InitModelHelper;

    protected $fillable = [
        'payment_id',
        'external_id',
        'operation_id',
        'status',
        'info',
    ];

    protected $casts = [
        'info'   => InfoData::class,
        'status' => StatusEnum::class,
    ];

    protected $touches = [
        'parent',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection(static::details()->connection);
        $this->setTable(static::details()->table);

        parent::__construct($attributes);
    }

    public function parent(): Relation
    {
        $payment = Config::payment()->model;

        $key = $this->model()->primaryKey($payment);

        return $this->belongsTo($payment, 'payment_id', $key);
    }
}
