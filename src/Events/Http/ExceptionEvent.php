<?php

declare(strict_types=1);

namespace Helldar\Cashier\Events\Http;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class ExceptionEvent
{
    use InteractsWithSockets;
    use SerializesModels;

    public $code;

    public $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;

        $this->message = $message;
    }
}
