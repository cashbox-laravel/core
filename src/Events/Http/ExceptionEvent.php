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

namespace Helldar\Cashier\Events\Http;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class ExceptionEvent
{
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The status code.
     *
     * @var int
     */
    public $code;

    /**
     * The message of the exception.
     *
     * @var string
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param  int  $code
     * @param  string  $message
     */
    public function __construct(int $code, string $message)
    {
        $this->code = $code;

        $this->message = $message;
    }
}
