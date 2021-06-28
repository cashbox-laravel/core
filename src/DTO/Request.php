<?php

namespace Helldar\Cashier\DTO;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Http;

final class Request
{
    use Makeable;

    protected $uri;

    protected $headers;

    protected $data;

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri): self
    {
        $this->uri = Http::validatedUrl($uri);

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
