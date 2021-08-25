<?php

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
