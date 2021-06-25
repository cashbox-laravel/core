<?php

namespace Helldar\Cashier\DTO;

use Helldar\Support\Concerns\Makeable;
use Illuminate\Contracts\Support\Arrayable;

class Response implements Arrayable
{
    use Makeable;

    /** @var string */
    protected $status;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
